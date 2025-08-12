@extends('layouts.admin')

@section('title', 'Contact Submissions')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Contact Submissions</h1>
    <div class="flex items-center space-x-4">
        <div class="text-sm text-gray-600">
            Total: {{ $contacts->total() }}
        </div>
    </div>
</div>

@if($contacts->count() > 0)
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <form id="bulk-action-form" method="POST" action="{{ route('admin.content.contacts.bulk-action') }}">
            @csrf
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="select-all" class="text-sm text-gray-700">Select All</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select name="action" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                            <option value="">Bulk Actions</option>
                            <option value="mark_read">Mark as Read</option>
                            <option value="mark_replied">Mark as Replied</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

            <ul class="divide-y divide-gray-200">
                @foreach($contacts as $contact)
                    <li class="px-4 py-4 sm:px-6 {{ $contact->status === 'new' ? 'bg-blue-50' : '' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" name="contacts[]" value="{{ $contact->id }}" 
                                       class="contact-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $contact->name }}</h3>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                            {{ $contact->status === 'new' ? 'bg-red-100 text-red-800' : 
                                               ($contact->status === 'read' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $contact->email }}</p>
                                    @if($contact->subject)
                                        <p class="text-sm text-gray-800 font-medium mt-1">{{ $contact->subject }}</p>
                                    @endif
                                    <p class="text-sm text-gray-700 mt-2">{{ Str::limit($contact->message, 200) }}</p>
                                    <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                        <span>{{ $contact->created_at->format('M d, Y \a\t g:i A') }}</span>
                                        <span>{{ $contact->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.content.contacts.show', $contact) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">View</a>
                                @if($contact->status !== 'replied')
                                    <button type="button" onclick="markAsReplied({{ $contact->id }})" 
                                            class="text-green-600 hover:text-green-900 text-sm font-medium">
                                        Mark Replied
                                    </button>
                                @endif
                                <button type="button" onclick="deleteContact({{ $contact->id }})" 
                                        class="text-red-600 hover:text-red-900 text-sm font-medium">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </form>
    </div>


    @foreach($contacts as $contact)
        @if($contact->status !== 'replied')
            <form id="mark-replied-form-{{ $contact->id }}" method="POST" action="{{ route('admin.content.contacts.update-status', $contact) }}" style="display: none;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="replied">
            </form>
        @endif
        <form id="delete-form-{{ $contact->id }}" method="POST" action="{{ route('admin.content.contacts.destroy', $contact) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    <div class="mt-6">
        {{ $contacts->links() }}
    </div>
@else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No contact submissions</h3>
        <p class="mt-1 text-sm text-gray-500">No one has contacted you through the website yet.</p>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    const bulkForm = document.getElementById('bulk-action-form');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
    }

    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
            const actionSelect = document.querySelector('select[name="action"]');
            const action = actionSelect ? actionSelect.value : '';
            
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one contact.');
                return false;
            }
            
            if (!action) {
                e.preventDefault();
                alert('Please select an action.');
                return false;
            }
            
            if (action === 'delete') {
                if (!confirm('Are you sure you want to delete the selected contacts?')) {
                    e.preventDefault();
                    return false;
                }
            }
            
            return true;
        });
    }
});

function markAsReplied(contactId) {
    const form = document.getElementById('mark-replied-form-' + contactId);
    if (form) {
        form.submit();
    }
}

function deleteContact(contactId) {
    if (confirm('Are you sure you want to delete this contact?')) {
        const form = document.getElementById('delete-form-' + contactId);
        if (form) {
            form.submit();
        }
    }
}
</script>
@endsection