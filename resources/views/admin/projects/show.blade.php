@extends('layouts.admin')

@section('title', 'View Project')

@section('content')
<div class="space-y-6">
 
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $project->title }}</h1>
            <p class="text-gray-600">Project Details</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('projects.show', $project) }}" 
               target="_blank"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                View Live
            </a>
            <a href="{{ route('admin.projects.edit', $project) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Edit Project
            </a>
            <a href="{{ route('admin.projects.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Projects
            </a>
        </div>
    </div>

   
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Project Information</h2>
        </div>
        
        <div class="px-6 py-4 space-y-6">
          
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Title</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $project->title }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Slug</h3>
                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ $project->slug }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Status</h3>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Featured</h3>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->is_featured ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $project->is_featured ? 'Yes' : 'No' }}
                    </span>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Sort Order</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $project->sort_order }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Created</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $project->created_at->format('M j, Y g:i A') }}</p>
                </div>
            </div>

           
            @if($project->description)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $project->description }}</p>
                </div>
            @endif

         
            @if($project->project_url || $project->github_url)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Links</h3>
                    <div class="flex space-x-4">
                        @if($project->project_url)
                            <a href="{{ $project->project_url }}" 
                               target="_blank"
                               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Live Project
                            </a>
                        @endif
                        
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" 
                               target="_blank"
                               class="inline-flex items-center text-gray-600 hover:text-gray-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                                </svg>
                                GitHub
                            </a>
                        @endif
                    </div>
                </div>
            @endif

           
            @if($project->tags && count($project->tags) > 0)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->tags as $tag)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

        
            @if($project->technologies && count($project->technologies) > 0)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Technologies</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->technologies as $tech)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

          
            @if($project->thumbnail || ($project->images && count($project->images) > 0))
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-4">Images</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @if($project->thumbnail)
                            <div class="relative">
                                <img src="{{ asset(str_contains($project->thumbnail, '/') ? $project->thumbnail : 'images/' . $project->thumbnail) }}" 
                                     alt="Thumbnail" 
                                     class="w-full h-48 object-cover rounded-lg shadow-sm">
                                <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                    Thumbnail
                                </div>
                            </div>
                        @endif
                        
                        @if($project->images)
                            @foreach($project->images as $index => $image)
                                <div class="relative">
                                    <img src="{{ asset(str_contains($image, '/') ? $image : 'images/' . $image) }}" 
                                         alt="Project image {{ $index + 1 }}" 
                                         class="w-full h-48 object-cover rounded-lg shadow-sm">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

          
            @if($project->content)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Content</h3>
                    <div class="prose max-w-none">
                        <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-900 whitespace-pre-wrap">{{ $project->content }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

   
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Actions</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.projects.edit', $project) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Edit Project
            </a>
            
            @if($project->status === 'draft')
                <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="published">
                    <input type="hidden" name="title" value="{{ $project->title }}">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Publish Project
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="draft">
                    <input type="hidden" name="title" value="{{ $project->title }}">
                    <button type="submit" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Unpublish Project
                    </button>
                </form>
            @endif

            @if(!$project->is_featured)
                <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="is_featured" value="1">
                    <input type="hidden" name="title" value="{{ $project->title }}">
                    <input type="hidden" name="status" value="{{ $project->status }}">
                    <button type="submit" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Feature Project
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="is_featured" value="0">
                    <input type="hidden" name="title" value="{{ $project->title }}">
                    <input type="hidden" name="status" value="{{ $project->status }}">
                    <button type="submit" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Unfeature Project
                    </button>
                </form>
            @endif

            <form method="POST" 
                  action="{{ route('admin.projects.destroy', $project) }}" 
                  class="inline"
                  onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Delete Project
                </button>
            </form>
        </div>
    </div>
</div>
@endsection