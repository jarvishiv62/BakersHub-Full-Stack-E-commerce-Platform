@extends('layouts.app')

@section('content')
<div class="container mt-5 py-5">
    <div class="row">
        <div class="col-md-8">
            <h2>Checkout</h2>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Customer Information</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.index') }}" method="POST" id="checkout-form">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                   value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Delivery Address *</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Order Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="place-order-btn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                Place Order
                            </button>
                            
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                Back to Cart
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mt-5 py-2">
            <div class="card">
                <div class="card-header">
                    <h4>Order Summary</h4>
                </div>
                <div class="card-body">
                    @foreach($cart['items'] as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                {{ $item['name'] }} x{{ $item['qty'] }}
                            </div>
                            <div>₹{{ number_format($item['line_total'], 2) }}</div>
                        </div>
                    @endforeach
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between fw-bold">
                        <div>Total:</div>
                        <div>₹{{ number_format($cart['total'], 2) }}</div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Please review your order before placing it.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkout-form');
        const submitBtn = document.getElementById('place-order-btn');
        
        if (submitBtn) {
            const spinner = submitBtn.querySelector('.spinner-border');
            
            form.addEventListener('submit', function(e) {
                // Only prevent default if we're handling it with AJAX
                // For now, let the form submit normally
                // e.preventDefault();
                
                // Disable the submit button and show spinner
                submitBtn.disabled = true;
                if (spinner) {
                    spinner.classList.remove('d-none');
                }
                
                // Submit the form normally
                return true;
            });
        }
    });
</script>
@endpush
