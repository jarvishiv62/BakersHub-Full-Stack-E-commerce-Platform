@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Products</h1>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Rating</th>
                            <th>
                                <div class="d-flex align-items-center">
                                    <span>Status</span>
                                    <select id="status-filter" class="form-select form-select-sm ms-2" style="width: auto;">
                                        <option value="all" {{ !request()->has('status') ? 'selected' : '' }}>All</option>
                                        <option value="1" {{ request()->input('status') === '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ request()->input('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 50px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category }}</td>
                            <td>Rs {{ number_format($product->price, 2) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="text-warning me-1">
                                        <i class="fas fa-star"></i> {{ number_format($product->rating, 1) }}
                                    </span>
                                    <small class="text-muted">({{ $product->reviews_count }})</small>
                                </div>
                            </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch me-2">
                                            <input class="form-check-input status-toggle" 
                                                   type="checkbox" 
                                                   data-id="{{ $product->id }}"
                                                   {{ $product->is_active ? 'checked' : '' }}>
                                        </div>
                                        <span class="status-badge {{ $product->is_active ? 'active' : 'inactive' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit">Edit</i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this product?')"
                                                title="Delete">
                                            <i class="fas fa-trash">Delete</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .status-badge {
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-badge.active {
        background-color: #d1fae5;
        color: #065f46;
    }
    .status-badge.inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status toggle
    const statusToggles = document.querySelectorAll('.status-toggle');
    statusToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const productId = this.dataset.id;
            const is_active = this.checked ? 1 : 0;
            const row = this.closest('tr');
            
            fetch(`/admin/products/${productId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ is_active: is_active })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error('Failed to update status');
                }
                // Update the UI to reflect the change
                const statusBadge = row.querySelector('.status-badge');
                if (statusBadge) {
                    statusBadge.textContent = data.is_active ? 'Active' : 'Inactive';
                    statusBadge.className = `status-badge ${data.is_active ? 'active' : 'inactive'}`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked; // Revert the toggle on error
                alert('An error occurred while updating status: ' + error.message);
            });
        });
    });

    // Status filter handling
    const statusFilter = document.getElementById('status-filter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const status = this.value;
            const url = new URL(window.location.href);
            
            if (status === 'all') {
                url.searchParams.delete('status');
            } else {
                url.searchParams.set('status', status);
            }
            
            window.location.href = url.toString();
        });
    }
});
</script>
@endpush
