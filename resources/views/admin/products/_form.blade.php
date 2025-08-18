@props(['product' => null])

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" 
                           value="{{ old('name', $product->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" 
                              rows="5">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (Rs) *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs</span>
                                <input type="number" step="0.01" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" 
                                       value="{{ old('price', $product->price ?? '') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price (Rs)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs</span>
                                <input type="number" step="0.01" 
                                       class="form-control @error('sale_price') is-invalid @enderror" 
                                       id="sale_price" name="sale_price" 
                                       value="{{ old('sale_price', $product->sale_price ?? '') }}">
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" 
                                        {{ (old('category', $product->category ?? '') == $category) ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock Quantity *</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" min="0" 
                                   value="{{ old('stock', $product->stock ?? 0) }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Product Images</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="image" class="form-label">Main Image *</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" 
                           {{ !isset($product) ? 'required' : '' }}>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(isset($product) && $product->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                 class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="gallery" class="form-label">Gallery Images</label>
                    <input type="file" class="form-control" 
                           id="gallery" name="gallery[]" multiple>
                    @if(isset($product) && $product->gallery)
                        <div class="row mt-2">
                            @foreach(json_decode($product->gallery) as $image)
                                <div class="col-md-3 mb-2">
                                    <div class="position-relative">
                                        <img src="{{ asset($image) }}" class="img-thumbnail" 
                                             style="height: 100px; width: 100%; object-fit: cover;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                                onclick="removeGalleryImage(this, '{{ $image }}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Publish</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" name="status">
                        <option value="draft" {{ (old('status', $product->status ?? '') == 'draft') ? 'selected' : '' }}>
                            Draft
                        </option>
                        <option value="published" {{ (old('status', $product->status ?? '') == 'published') ? 'selected' : '' }}>
                            Published
                        </option>
                        <option value="archived" {{ (old('status', $product->status ?? '') == 'archived') ? 'selected' : '' }}>
                            Archived
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="featured" class="form-check-label">
                        <input type="checkbox" class="form-check-input" 
                               id="featured" name="featured" value="1"
                               {{ old('featured', $product->featured ?? 0) ? 'checked' : '' }}>
                        Mark as Featured
                    </label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> 
                        {{ isset($product) ? 'Update' : 'Create' }} Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Product Attributes</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" step="0.01" class="form-control" 
                           id="weight" name="weight" 
                           value="{{ old('weight', $product->weight ?? '') }}">
                </div>
                
                <div class="mb-3">
                    <label for="dimensions" class="form-label">Dimensions (L x W x H)</label>
                    <div class="input-group">
                        <input type="number" step="0.1" class="form-control" 
                               placeholder="Length" name="dimensions[length]"
                               value="{{ old('dimensions.length', $product->dimensions['length'] ?? '') }}">
                        <span class="input-group-text">x</span>
                        <input type="number" step="0.1" class="form-control" 
                               placeholder="Width" name="dimensions[width]"
                               value="{{ old('dimensions.width', $product->dimensions['width'] ?? '') }}">
                        <span class="input-group-text">x</span>
                        <input type="number" step="0.1" class="form-control" 
                               placeholder="Height" name="dimensions[height]"
                               value="{{ old('dimensions.height', $product->dimensions['height'] ?? '') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = document.createElement('img');
            preview.className = 'img-thumbnail mt-2';
            preview.style.maxHeight = '150px';
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                const existingPreview = document.querySelector('#image ~ .img-thumbnail');
                if (existingPreview) {
                    existingPreview.remove();
                }
                document.getElementById('image').after(preview);
            }
            
            reader.readAsDataURL(file);
        }
    });

    function removeGalleryImage(button, imagePath) {
        if (confirm('Are you sure you want to remove this image?')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'removed_gallery_images[]';
            input.value = imagePath;
            document.querySelector('form').appendChild(input);
            
            button.closest('.col-md-3').remove();
        }
    }
</script>
@endpush