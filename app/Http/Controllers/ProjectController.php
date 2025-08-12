<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Content;
use App\Services\SEOService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        $pageTitleSettings = Content::byKey('page_titles_projects')->first();
        $defaultPageTitle = [
            'title' => 'My Projects',
            'content' => 'Explore my portfolio of web development and 3D modeling projects. Each project represents a unique challenge and creative solution.',
            'meta' => ['subtitle' => '']
        ];

        $query = Project::published()->ordered();
        
        if ($request->has('technology') && $request->technology) {
            $query->byTechnology($request->technology);
        }
        
        if ($request->has('tag') && $request->tag) {
            $query->byTag($request->tag);
        }
        
        $projects = $query->get();
        
        $allProjects = Project::published()->get();
        $technologies = $allProjects->pluck('technologies')->flatten()->unique()->filter()->sort()->values();
        $tags = $allProjects->pluck('tags')->flatten()->unique()->filter()->sort()->values();
        
        $seoData = $this->seoService->generateMetaTags('projects');
        
        return view('pages.projects.index', compact('projects', 'technologies', 'tags', 'seoData'))->with([
            'pageTitle' => $pageTitleSettings ? $pageTitleSettings->toArray() : $defaultPageTitle
        ]);
    }

    public function show(Project $project)
    {
        if (!$project->isPublished()) {
            abort(404);
        }
        
        $relatedProjects = collect();
        if ($project->technologies && count($project->technologies) > 0) {
            $relatedProjects = Project::published()
                ->where('id', '!=', $project->id)
                ->where(function ($query) use ($project) {
                    foreach ($project->technologies as $tech) {
                        $query->orWhereJsonContains('technologies', $tech);
                    }
                })
                ->ordered()
                ->limit(3)
                ->get();
        }
        
        $seoData = $this->seoService->generateMetaTags('projects', $project);
        
        return view('pages.projects.show', compact('project', 'relatedProjects', 'seoData'));
    }
}