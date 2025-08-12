<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Content;
use App\Services\SEOService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index()
    {
        $pageTitleSettings = Content::byKey('page_titles_blog')->first();
        $defaultPageTitle = [
            'title' => 'Blog',
            'content' => 'Insights, tutorials, and thoughts on web development, 3D modeling, and design.',
            'meta' => ['subtitle' => '']
        ];

        $blogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $seoData = $this->seoService->generateMetaTags('blog');

        return view('pages.blog.index', compact('blogs', 'seoData'))->with([
            'pageTitle' => $pageTitleSettings ? $pageTitleSettings->toArray() : $defaultPageTitle
        ]);
    }

    public function show(Blog $blog)
    {
        if (!$blog->isPublished()) {
            abort(404);
        }

        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where(function ($query) use ($blog) {
                if ($blog->tags) {
                    foreach ($blog->tags as $tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    }
                }
            })
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $previousBlog = Blog::published()
            ->where('published_at', '<', $blog->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $nextBlog = Blog::published()
            ->where('published_at', '>', $blog->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        $seoData = $this->seoService->generateMetaTags('blog', $blog);

        return view('pages.blog.show', compact('blog', 'relatedBlogs', 'previousBlog', 'nextBlog', 'seoData'));
    }
}