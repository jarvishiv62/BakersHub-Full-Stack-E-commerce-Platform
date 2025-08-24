@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Order Management</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
            <div class="d-flex">
                <div class="me-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="ordersTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->customer_name ?? 'Guest Customer' }}</td>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <span class="badge 
                                                {{ $order->status === 'pending' ? 'bg-warning' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-info' : '' }}
                                                {{ $order->status === 'shipped' ? 'bg-primary' : '' }}
                                                {{ $order->status === 'delivered' ? 'bg-success' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}
                                                status-badge" data-status="{{ $order->status }}"
                                        data-order-id="{{ $order->id }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($order->total, 2) }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary"
                                            title="View Order">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item status-update" href="#" data-status="processing"
                                                    data-id="{{ $order->id }}">
                                                    Mark as Processing
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item status-update" href="#" data-status="shipped"
                                                    data-id="{{ $order->id }}">
                                                    Mark as Shipped
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-success status-update" href="#"
                                                    data-status="delivered" data-id="{{ $order->id }}">
                                                    <i class="bi bi-check-circle me-1"></i> Mark as Delivered
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger status-update" href="#"
                                                    data-status="cancelled" data-id="{{ $order->id }}">
                                                    <i class="bi bi-x-circle me-1"></i> Cancel Order
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="mt-2 mb-0">No orders found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/admin-orders.js') }}"></script>
    @endpush
@endsection