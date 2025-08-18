@csrf

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" 
           id="name" name="name" value="{{ old('name', $testimonial->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="role" class="form-label">Role/Position</label>
    <input type="text" class="form-control @error('role') is-invalid @enderror" 
           id="role" name="role" value="{{ old('role', $testimonial->role ?? '') }}" required>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="quote" class="form-label">Testimonial</label>
    <textarea class="form-control @error('quote') is-invalid @enderror" 
              id="quote" name="quote" rows="4" required>{{ old('quote', $testimonial->quote ?? '') }}</textarea>
    @error('quote')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="rating" class="form-label">Rating</label>
        <select class="form-select @error('rating') is-invalid @enderror" 
                id="rating" name="rating" required>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ (old('rating', $testimonial->rating ?? '') == $i) ? 'selected' : '' }}>
                    {{ $i }} {{ $i === 1 ? 'Star' : 'Stars' }}
                </option>
            @endfor
        </select>
        @error('rating')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" 
                   id="is_active" name="is_active" value="1"
                   {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mt-4">
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> {{ isset($testimonial) ? 'Update' : 'Create' }}
    </button>
</div>