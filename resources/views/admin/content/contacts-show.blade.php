@extends('layouts.admin')

@section('title', 'Contact Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Contact Details</h1>
        <a href="{{ route('admin.content.contacts') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Back to Contacts
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">{{ $contact->name }}</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ $contact->status === 'new' ? 'bg-red-100 text-red-800' : 
                       ($contact->status === 'read' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                    {{ ucfirst($contact->status) }}
                </span>
            </div>
        </div>

        <div class="px-6 py-4 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Email Address</h3>
                    <p class="text-gray-900">
                        <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">
                            {{ $contact->email }}
                        </a>
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Submitted</h3>
                    <p class="text-gray-900">{{ $contact->created_at->format('M d, Y \a\t g:i A') }}</p>
                    <p class="text-sm text-gray-500">{{ $contact->created_at->diffForHumans() }}</p>
                </div>
            </div>

            @if($contact->subject)
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Subject</h3>
                    <p class="text-gray-900">{{ $contact->subject }}</p>
                </div>
            @endif

            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Message</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $contact->message }}</p>
                </div>
            </div>

           
            <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject ?? 'Your inquiry' }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Reply via Email
                </a>

                @if($contact->status !== 'replied')
                    <form method="POST" action="{{ route('admin.content.contacts.update-status', $contact) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="replied">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark as Replied
                        </button>
                    </form>
                @endif

                @if($contact->status === 'new')
                    <form method="POST" action="{{ route('admin.content.contacts.update-status', $contact) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="read">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Mark as Read
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <form method="POST" action="{{ route('admin.content.contacts.destroy', $contact) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this contact? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                        Delete Contact
                    </button>
                </form>

                <div class="text-sm text-gray-500">
                    Contact ID: {{ $contact->id }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection