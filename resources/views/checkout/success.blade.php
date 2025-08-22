@extends('layouts.app')

@section('content')
<div class="container mt-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#28a745" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                    </div>
                    
                    <h2 class="mb-3">Thank You for Your Order!</h2>
                    <p class="lead">Your order has been placed successfully.</p>
                    <p>Order ID: <strong>#{{ $order->id }}</strong></p>
                    
                    <div class="mt-4">
                        <p>We've sent an order confirmation to your email.</p>
                        <p>You will receive an email when your order ships.</p>
                    </div>
                    
                    <div class="mt-5">
                        <a href="{{ route('home') }}" class="btn btn-primary me-2">Continue Shopping</a>
                        <a href="#" class="btn btn-outline-secondary">View Order Status</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
