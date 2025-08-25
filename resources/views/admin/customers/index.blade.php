@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Customer Management</h1>
        <div>
            <a href="#" class="btn btn-outline-secondary me-2">
                <i class="bi bi-download"></i> Export
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="customersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr>
                            <td>#{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td>{{ $customer->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @php
                                            $newStatus = $customer->status === 'active' ? 'inactive' : 'active';
                                            $action = $newStatus === 'active' ? 'activate' : 'deactivate';
                                        @endphp
                                        <input type="hidden" name="status" value="{{ $newStatus }}">
                                        <button 
                                            type="submit" 
                                            class="btn btn-sm btn-outline-{{ $newStatus === 'active' ? 'success' : 'warning' }}" 
                                            onclick="return confirm('Are you sure you want to {{ $action }} this customer?')">
                                            <i class="bi {{ $newStatus === 'active' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No customers found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($customers->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $customers->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#customersTable').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"top"f>rt<"bottom"ip><"clear">',
            language: {
                search: "",
                searchPlaceholder: "Search customers...",
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                }
            },
            order: [[0, 'desc']]
        });
    });
</script>
@endpush
@endsection
