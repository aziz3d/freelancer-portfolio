@extends('layouts.admin')

@section('title', 'Content Management')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Content Management</h1>
    </div>

   
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
       
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">General Settings</h2>
                <p class="text-sm text-gray-600">Hero Section & Footer Content</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Hero Section</span>
                        <span class="text-xs text-gray-500">Homepage banner</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Footer Content</span>
                        <span class="text-xs text-gray-500">Site footer</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.content.general-settings') }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Manage General Settings
                    </a>
                </div>
            </div>
        </div>

      
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Site Branding</h2>
                <p class="text-sm text-gray-600">Logo, Favicon & Site Title</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Site Logo</span>
                        <span class="text-xs text-gray-500">Navbar branding</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Favicon</span>
                        <span class="text-xs text-gray-500">Browser tab icon</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Site Title</span>
                        <span class="text-xs text-gray-500">Page titles & SEO</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.content.branding-settings') }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        Manage Branding Settings
                    </a>
                </div>
            </div>
        </div>

     
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">About Page Settings</h2>
                <p class="text-sm text-gray-600">Profile, Experience & Resume</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Profile & Summary</span>
                        <span class="text-xs text-gray-500">Bio & intro</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Work Experience</span>
                        <span class="text-xs text-gray-500">Career timeline</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Resume & Social</span>
                        <span class="text-xs text-gray-500">Downloads & links</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.content.about-settings') }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                        Manage About Settings
                    </a>
                </div>
            </div>
        </div>

      
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Contact Settings</h2>
                <p class="text-sm text-gray-600">Contact Info & reCAPTCHA</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Contact Information</span>
                        <span class="text-xs text-gray-500">Email & location</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Social Links</span>
                        <span class="text-xs text-gray-500">Connect with me</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">reCAPTCHA</span>
                        <span class="text-xs text-gray-500">Spam protection</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.content.contact-settings') }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
                        Manage Contact Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

 
    <div class="bg-white shadow-sm rounded-lg mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Services Settings</h2>
            <p class="text-sm text-gray-600">Services Page Call-to-Action</p>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">CTA Section</span>
                    <span class="text-xs text-gray-500">Bottom of services page</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Button Actions</span>
                    <span class="text-xs text-gray-500">Primary & secondary CTAs</span>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.content.services-settings') }}" 
                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Manage Services Settings
                </a>
            </div>
        </div>
    </div>

   
    <div class="bg-white shadow-sm rounded-lg mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Pages Title Settings</h2>
            <p class="text-sm text-gray-600">Hero Header Titles & Descriptions</p>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">About Me Page</span>
                    <span class="text-xs text-gray-500">Hero title & description</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Projects Page</span>
                    <span class="text-xs text-gray-500">Hero title & description</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Blog Page</span>
                    <span class="text-xs text-gray-500">Hero title & description</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Services Page</span>
                    <span class="text-xs text-gray-500">Hero title & description</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Contact Me Page</span>
                    <span class="text-xs text-gray-500">Hero title & description</span>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.content.pages-title-settings') }}" 
                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Manage Pages Title Settings
                </a>
            </div>
        </div>
    </div>




   
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Contact Submissions</h2>
            <p class="text-sm text-gray-600">Latest messages from the contact form</p>
        </div>
        <div class="p-6">
            @if($contacts->count() > 0)
                <div class="space-y-4">
                    @foreach($contacts->take(5) as $contact)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-medium text-gray-900">{{ $contact->name }}</h4>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $contact->status === 'new' ? 'bg-red-100 text-red-800' : 
                                           ($contact->status === 'read' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($contact->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $contact->email }}</p>
                                @if($contact->subject)
                                    <p class="text-sm text-gray-800 font-medium">{{ $contact->subject }}</p>
                                @endif
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($contact->message, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $contact->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('admin.content.contacts.show', $contact) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.content.contacts') }}" 
                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                        View All Contacts ({{ $contacts->total() }})
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No contact submissions yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection