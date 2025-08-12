<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Blog::query();

        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'scheduled') {
                $query->scheduled();
            } else {
                $query->where('status', $status);
            }
        }

        
        if ($request->filled('tag')) {
            $query->byTag($request->get('tag'));
        }

       
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        if (in_array($sortBy, ['title', 'status', 'published_at', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $blogs = $query->paginate(15)->withQueryString();

        
        $allTags = Blog::whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('admin.blog.index', compact('blogs', 'allTags'));
    }

    
    public function create()
    {
        return view('admin.blog.create');
    }

    
    public function store(BlogRequest $request)
    {
        try {
            $data = $request->validated();

            
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $this->handleImageUpload($request->file('thumbnail'));
                $data['thumbnail'] = $thumbnailPath;
            }

            
            if (empty($data['slug'])) {
                $data['slug'] = Blog::generateUniqueSlug($data['title']);
            }

            $blog = Blog::create($data);

            return redirect()
                ->route('admin.blog.index')
                ->with('success', 'Blog post created successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create blog post. Please try again.');
        }
    }

   
    public function show(Blog $blog)
    {
        return view('admin.blog.show', compact('blog'));
    }

    
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

   
    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $data = $request->validated();

            
            if ($request->hasFile('thumbnail')) {
                
                if ($blog->thumbnail) {
                    $this->deleteImage($blog->thumbnail);
                }
                
                $thumbnailPath = $this->handleImageUpload($request->file('thumbnail'));
                $data['thumbnail'] = $thumbnailPath;
            }

            
            if (empty($data['slug'])) {
                $data['slug'] = Blog::generateUniqueSlug($data['title']);
            }

            $blog->update($data);

            return redirect()
                ->route('admin.blog.index')
                ->with('success', 'Blog post updated successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update blog post. Please try again.');
        }
    }

   
    public function destroy(Blog $blog)
    {
        try {
            
            if ($blog->thumbnail) {
                $this->deleteImage($blog->thumbnail);
            }

            $blog->delete();

            return redirect()
                ->route('admin.blog.index')
                ->with('success', 'Blog post deleted successfully!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete blog post. Please try again.');
        }
    }

   
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,draft',
            'selected_blogs' => 'required|array|min:1',
            'selected_blogs.*' => 'exists:blogs,id',
        ]);

        $blogIds = $request->get('selected_blogs');
        $action = $request->get('action');

        try {
            switch ($action) {
                case 'delete':
                    $blogs = Blog::whereIn('id', $blogIds)->get();
                    foreach ($blogs as $blog) {
                        if ($blog->thumbnail) {
                            $this->deleteImage($blog->thumbnail);
                        }
                    }
                    Blog::whereIn('id', $blogIds)->delete();
                    $message = 'Selected blog posts deleted successfully!';
                    break;

                case 'publish':
                    Blog::whereIn('id', $blogIds)->update([
                        'status' => 'published',
                        'published_at' => now(),
                    ]);
                    $message = 'Selected blog posts published successfully!';
                    break;

                case 'draft':
                    Blog::whereIn('id', $blogIds)->update([
                        'status' => 'draft',
                        'published_at' => null,
                    ]);
                    $message = 'Selected blog posts moved to draft successfully!';
                    break;
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to perform bulk action. Please try again.');
        }
    }

   
    private function handleImageUpload($file)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = 'images/blog/' . $filename;
        
        
        $file->move(public_path('images/blog'), $filename);
        
        return $path;
    }

    
    private function deleteImage($imagePath)
    {
        $fullPath = public_path($imagePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}