@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Occasion: {{ $occasion->title }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.occasions.index') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
        <form action="{{ route('admin.occasions.destroy', $occasion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this occasion?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.occasions.update', $occasion->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            @include('admin.occasions._form')
            
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any additional JavaScript for the edit form here
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        let previewContainer = document.querySelector('.image-preview');
                        
                        if (!previewContainer) {
                            previewContainer = document.createElement('div');
                            previewContainer.className = 'mt-2 image-preview';
                            imageInput.parentNode.insertBefore(previewContainer, imageInput.nextSibling);
                        }
                        
                        previewContainer.innerHTML = `
                            <p class="mb-1">New Image Preview:</p>
                            <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px;">
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    const previewContainer = document.querySelector('.image-preview');
                    if (previewContainer) {
                        previewContainer.remove();
                    }
                }
            });
        }
    });
</script>
@endpush