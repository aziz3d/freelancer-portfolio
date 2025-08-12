<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search)
                  ->orWhereJsonContains('technologies', $search);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->get('featured') === '1');
        }

        if ($request->filled('technology')) {
            $query->whereJsonContains('technologies', $request->get('technology'));
        }

        $projects = $query->orderBy('sort_order')
                         ->orderBy('created_at', 'desc')
                         ->paginate(15)
                         ->withQueryString();

        $technologies = Project::whereNotNull('technologies')
                              ->get()
                              ->pluck('technologies')
                              ->flatten()
                              ->unique()
                              ->sort()
                              ->values();

        return view('admin.projects.index', compact('projects', 'technologies'));
    }

    
    public function create()
    {
        return view('admin.projects.create');
    }

    
    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadImage($request->file('thumbnail'), 'thumbnails');
        }

        if ($request->hasFile('project_images')) {
            $images = [];
            foreach ($request->file('project_images') as $image) {
                $images[] = $this->uploadImage($image, 'projects');
            }
            $data['images'] = $images;
        }

        $data['tags'] = $this->processArrayInput($request->input('tags'));
        $data['technologies'] = $this->processArrayInput($request->input('technologies'));

        if (empty($data['slug'])) {
            $data['slug'] = Project::generateUniqueSlug($data['title']);
        }

        $project = Project::create($data);

        return redirect()->route('admin.projects.index')
                        ->with('success', 'Project created successfully.');
    }

    
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    
    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                $this->deleteImage($project->thumbnail);
            }
            $data['thumbnail'] = $this->uploadImage($request->file('thumbnail'), 'thumbnails');
        }

        if ($request->hasFile('project_images')) {
            if ($project->images) {
                foreach ($project->images as $image) {
                    $this->deleteImage($image);
                }
            }
            
            $images = [];
            foreach ($request->file('project_images') as $image) {
                $images[] = $this->uploadImage($image, 'projects');
            }
            $data['images'] = $images;
        }

        $data['tags'] = $this->processArrayInput($request->input('tags'));
        $data['technologies'] = $this->processArrayInput($request->input('technologies'));

        if ($data['title'] !== $project->title && empty($data['slug'])) {
            $data['slug'] = Project::generateUniqueSlug($data['title']);
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')
                        ->with('success', 'Project updated successfully.');
    }

    
    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            $this->deleteImage($project->thumbnail);
        }

        if ($project->images) {
            foreach ($project->images as $image) {
                $this->deleteImage($image);
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
                        ->with('success', 'Project deleted successfully.');
    }

    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,unpublish,feature,unfeature',
            'projects' => 'required|array',
            'projects.*' => 'exists:projects,id'
        ]);

        $projects = Project::whereIn('id', $request->projects);

        switch ($request->action) {
            case 'delete':
                foreach ($projects->get() as $project) {
                    if ($project->thumbnail) {
                        $this->deleteImage($project->thumbnail);
                    }
                    if ($project->images) {
                        foreach ($project->images as $image) {
                            $this->deleteImage($image);
                        }
                    }
                }
                $projects->delete();
                $message = 'Selected projects deleted successfully.';
                break;

            case 'publish':
                $projects->update(['status' => 'published']);
                $message = 'Selected projects published successfully.';
                break;

            case 'unpublish':
                $projects->update(['status' => 'draft']);
                $message = 'Selected projects unpublished successfully.';
                break;

            case 'feature':
                $projects->update(['is_featured' => true]);
                $message = 'Selected projects featured successfully.';
                break;

            case 'unfeature':
                $projects->update(['is_featured' => false]);
                $message = 'Selected projects unfeatured successfully.';
                break;
        }

        return redirect()->route('admin.projects.index')
                        ->with('success', $message);
    }

    
    private function uploadImage($file, $directory)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = "images/{$directory}";
        
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0755, true);
        }

        $file->move(public_path($path), $filename);
        
        return "{$path}/{$filename}";
    }

    
    private function deleteImage($imagePath)
    {
        $fullPath = public_path($imagePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    
    private function processArrayInput($input)
    {
        if (is_array($input)) {
            return array_filter($input);
        }

        if (is_string($input)) {
            return array_filter(array_map('trim', explode(',', $input)));
        }

        return [];
    }
}