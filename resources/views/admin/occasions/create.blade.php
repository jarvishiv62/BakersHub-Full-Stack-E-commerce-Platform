@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Occasion</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.occasions.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.occasions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            @include('admin.occasions._form')
            
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any additional JavaScript for the create form here
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewContainer = document.createElement('div');
                        previewContainer.className = 'mt-2';
                        previewContainer.innerHTML = `
                            <p class="mb-1">Preview:</p>
                            <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px;">
                        `;
                        
                        // Remove existing preview if any
                        const existingPreview = document.querySelector('.image-preview');
                        if (existingPreview) {
                            existingPreview.remove();
                        }
                        
                        previewContainer.classList.add('image-preview');
                        imageInput.parentNode.insertBefore(previewContainer, imageInput.nextSibling);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush