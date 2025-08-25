@extends('layouts.admin')

@section('title', 'Customer Details - ' . $customer->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Customer Details</h1>
        <div>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Customers
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="avatar-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border-radius: 50%; font-size: 3rem;">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $customer->name }}</h4>
                    <p class="text-muted mb-3">{{ $customer->email }}</p>
                    
                    <div class="d-flex justify-content-center mb-3">
                        <span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'secondary' }} me-2">
                            {{ ucfirst($customer->status) }}
                        </span>
                        <span class="badge bg-info">
                            Member since {{ $customer->created_at->format('M Y') }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-center">
                        <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" class="me-2">
                            @csrf
                            @method('PATCH')
                            @php
                                $newStatus = $customer->status === 'active' ? 'inactive' : 'active';
                                $buttonText = $newStatus === 'active' ? 'Activate' : 'Deactivate';
                                $buttonClass = $newStatus === 'active' ? 'success' : 'warning';
                                $iconClass = $newStatus === 'active' ? 'bi-check-circle' : 'bi-x-circle';
                            @endphp
                            <input type="hidden" name="status" value="{{ $newStatus }}">
                            <button type="submit" class="btn btn-{{ $buttonClass }} btn-sm"
                                    onclick="return confirm('Are you sure you want to {{ strtolower($buttonText) }} this customer?')">
                                <i class="bi {{ $iconClass }} me-1"></i>
                                {{ $buttonText }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">Contact Information</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        {{ $customer->email }}
                    </p>
                    @if($customer->phone)
                    <p class="mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        {{ $customer->phone }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Order History</h6>
                    <span class="badge bg-primary">{{ $customer->orders->count() }} Orders</span>
                </div>
                <div class="card-body">
                    @if($customer->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-cart-x display-4 text-muted mb-3"></i>
                            <p class="text-muted">No orders found for this customer.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
