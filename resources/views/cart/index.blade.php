@extends('layouts.app')

@section('content')
<div class="container mt-5 py-5">
    <h1>Your Shopping Cart</h1>
    
    @if(count($cart['items']) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart['items'] as $item)
                        <tr data-product-id="{{ $item['id'] }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $product = \App\Models\Product::find($item['id']);
                                        $imageUrl = $product ? $product->image_url : asset('images/placeholder.jpg');
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" 
                                         class="img-thumbnail me-3" style="width: 64px; height: 64px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0">{{ $item['name'] }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>₹{{ number_format($item['price'], 2) }}</td>
                            <td>
                                <input type="number" class="form-control update-quantity" 
                                       value="{{ $item['qty'] }}" min="1" style="width: 70px;">
                            </td>
                            <td class="item-total">₹{{ number_format($item['line_total'], 2) }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-item" data-id="{{ $item['id'] }}">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2" id="cart-total">₹{{ number_format($cart['total'], 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="text-end mt-3">
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products') }}">Continue shopping</a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update quantity
        document.querySelectorAll('.update-quantity').forEach(function(element) {
            element.addEventListener('change', function() {
                const row = this.closest('tr');
                const productId = row.dataset.productId;
                const quantity = this.value;
                
                if (!productId || !quantity) return;
                
                fetch(`/cart/update/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.querySelector('.item-total').textContent = '₹' + parseFloat(data.item_total).toFixed(2);
                        document.getElementById('cart-total').textContent = '₹' + parseFloat(data.cart_total).toFixed(2);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Remove item
        document.querySelectorAll('.remove-item').forEach(function(button) {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove this item?')) {
                    const productId = this.dataset.id;
                    const row = this.closest('tr');
                    
                    if (!productId) return;
                    
                    fetch(`/cart/remove/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            const cartTotal = document.getElementById('cart-total');
                            if (cartTotal) {
                                cartTotal.textContent = '₹' + parseFloat(data.cart_total).toFixed(2);
                            }
                            
                            if (data.cart_count === 0) {
                                location.reload();
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });
    });
</script>
@endpush
@endsection
