@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Occasions</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.occasions.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Occasion
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($occasions as $index => $occasion)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($occasion->image)
                        <img src="{{ asset('storage/' . $occasion->image) }}" alt="{{ $occasion->alt_text }}" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                </td>
                <td>{{ $occasion->title }}</td>
                <td>{{ Str::limit($occasion->description, 50) }}</td>
                <td>
                    <span class="badge {{ $occasion->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $occasion->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>{{ $occasion->sort_order }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.occasions.edit', $occasion->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.occasions.destroy', $occasion->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this occasion?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No occasions found. <a href="{{ route('admin.occasions.create') }}">Create one</a>.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection