@if(isset($occasion) && $occasion->image)
    <div class="mb-3">
        <label class="form-label">Current Image</label>
        <div>
            <img src="{{ asset('storage/' . $occasion->image) }}" alt="{{ $occasion->alt_text }}" class="img-thumbnail" style="max-height: 200px;">
        </div>
    </div>
@endif

<div class="mb-3">
    <label for="image" class="form-label">{{ isset($occasion) ? 'Change ' : '' }}Image</label>
    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" {{ !isset($occasion) ? 'required' : '' }}>
    <div class="form-text">Recommended size: 800x600px. Max file size: 2MB</div>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" 
           value="{{ old('title', $occasion->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" 
              name="description" rows="3" required>{{ old('description', $occasion->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="alt_text" class="form-label">Image Alt Text</label>
    <input type="text" class="form-control @error('alt_text') is-invalid @enderror" id="alt_text" name="alt_text" 
           value="{{ old('alt_text', $occasion->alt_text ?? '') }}" required>
    @error('alt_text')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="route" class="form-label">Route</label>
    <input type="text" class="form-control @error('route') is-invalid @enderror" id="route" name="route" 
           value="{{ old('route', $occasion->route ?? '') }}" required>
    <div class="form-text">The URL path where this occasion will link to (e.g., /products?occasion=birthday)</div>
    @error('route')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="sort_order" class="form-label">Sort Order</label>
        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" 
               name="sort_order" value="{{ old('sort_order', $occasion->sort_order ?? 0) }}" min="0">
        @error('sort_order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="form-check form-switch mt-4 pt-2">
            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" 
                   value="1" {{ (old('is_active', $occasion->is_active ?? true) ? 'checked' : '') }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>
</div>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="{{ route('admin.occasions.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
    <button type="submit" class="btn btn-primary">
        {{ isset($occasion) ? 'Update Occasion' : 'Create Occasion' }}
    </button>
</div>