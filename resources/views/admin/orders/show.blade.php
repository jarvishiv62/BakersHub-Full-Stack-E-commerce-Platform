@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Orders
            </a>
            @if($order->status !== 'cancelled' && $order->status !== 'delivered')
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear me-1"></i> Actions
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if($order->status === 'pending')
                            <li>
                                <a class="dropdown-item status-update" href="#" data-status="processing">
                                    <i class="bi bi-arrow-repeat me-2"></i>Mark as Processing
                                </a>
                            </li>
                        @endif
                        @if($order->status === 'processing')
                            <li>
                                <a class="dropdown-item status-update" href="#" data-status="shipped">
                                    <i class="bi bi-truck me-2"></i>Mark as Shipped
                                </a>
                            </li>
                        @endif
                        @if($order->status === 'shipped')
                            <li>
                                <a class="dropdown-item status-update text-success" href="#" data-status="delivered">
                                    <i class="bi bi-check-circle me-2"></i>Mark as Delivered
                                </a>
                            </li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger status-update" href="#" data-status="cancelled">
                                <i class="bi bi-x-circle me-2"></i>Cancel Order
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <!-- Order Timeline -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Status</h6>
                </div>
                <div class="card-body">
                    <div class="order-timeline">
                        <div class="timeline-step {{ in_array($order->status, ['processing', 'shipped', 'delivered', 'cancelled']) ? 'completed' : ($order->status === 'pending' ? 'active' : '') }}">
                            <h6 class="mb-1">Order Placed</h6>
                            <p class="text-muted small mb-0">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                        </div>
                        
                        @if($order->status === 'processing' || $order->status === 'shipped' || $order->status === 'delivered')
                        <div class="timeline-step {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : ($order->status === 'processing' ? 'active' : '') }}">
                            <h6 class="mb-1">Processing</h6>
                            <p class="text-muted small mb-0">Order is being processed</p>
                        </div>
                        @endif
                        
                        @if($order->status === 'shipped' || $order->status === 'delivered')
                        <div class="timeline-step {{ $order->status === 'delivered' ? 'completed' : ($order->status === 'shipped' ? 'active' : '') }}">
                            <h6 class="mb-1">Shipped</h6>
                            <p class="text-muted small mb-0">Order has been shipped</p>
                        </div>
                        @endif
                        
                        @if($order->status === 'delivered')
                        <div class="timeline-step completed">
                            <h6 class="mb-1">Delivered</h6>
                            <p class="text-muted small mb-0">
                                @if($order->delivered_at)
                                    Delivered on {{ $order->delivered_at->format('M j, Y g:i A') }}
                                @else
                                    Order has been delivered
                                @endif
                            </p>
                        </div>
                        @endif
                        
                        @if($order->status === 'cancelled')
                        <div class="timeline-step">
                            <h6 class="mb-1">Cancelled</h6>
                            <p class="text-muted small mb-0">Order has been cancelled</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Order Items ({{ $order->items->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                         alt="{{ $item->name }}" 
                                                         class="product-img me-3 img-fluid"
                                                         style="height: 50px; width: 50px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <div class="fw-medium">{{ $item->name }}</div>
                                                    <div class="text-muted small">SKU: {{ $item->product_id }}</div>
                                                    @if($item->options && count($item->options) > 0)
                                                        <div class="mt-1">
                                                            @foreach($item->options as $key => $value)
                                                                <span class="badge bg-light text-dark me-1">
                                                                    {{ ucfirst($key) }}: {{ $value }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end align-middle">₹{{ number_format($item->price, 2) }}</td>
                                        <td class="text-center align-middle">{{ $item->qty }}</td>
                                        <td class="text-end align-middle fw-medium">₹{{ number_format($item->price * $item->qty, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Order Notes -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Notes</h6>
                </div>
                <div class="card-body">
                    @if($order->notes)
                        <div class="bg-light p-3 rounded">
                            {{ $order->notes }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-journal-text fs-1 text-muted mb-2"></i>
                            <p class="text-muted mb-0">No notes available for this order.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
                    <span class="badge 
                        {{ $order->status === 'pending' ? 'bg-warning' : '' }}
                        {{ $order->status === 'processing' ? 'bg-info' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-primary' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-success' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₹{{ number_format($order->items->sum(function ($item) {
    return $item->price * $item->qty; }), 2) }}</span>
                    </div>
                    
                    @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Discount:</span>
                        <span>-₹{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>₹{{ number_format($order->shipping_amount ?? 0, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span>₹{{ number_format($order->tax_amount ?? 0, 2) }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2 fw-bold">
                        <span>Total:</span>
                        <span>₹{{ number_format($order->total, 2) }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <h6 class="mb-2">Payment Information</h6>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Payment Method:</span>
                            <span class="text-capitalize">{{ $order->payment_method ? str_replace('_', ' ', $order->payment_method) : 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Payment Status:</span>
                            <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ $order->payment_status ? ucfirst($order->payment_status) : 'Pending' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($order->payment_id)
                    <div class="alert alert-info p-2 small mb-3">
                        <div class="d-flex">
                            <i class="bi bi-info-circle me-2"></i>
                            <div>
                                <div class="fw-medium">Payment ID:</div>
                                <code>{{ $order->payment_id }}</code>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="d-grid gap-2">
                        @if($order->status !== 'cancelled' && $order->status !== 'delivered')
                            @if($order->status === 'pending')
                                <button type="button" class="btn btn-outline-primary btn-sm status-update" data-status="processing">
                                    <i class="bi bi-arrow-repeat me-1"></i> Mark as Processing
                                </button>
                            @endif
                            @if($order->status === 'processing')
                                <button type="button" class="btn btn-outline-primary btn-sm status-update" data-status="shipped">
                                    <i class="bi bi-truck me-1"></i> Mark as Shipped
                                </button>
                            @endif
                            @if($order->status === 'shipped')
                                <button type="button" class="btn btn-success btn-sm status-update" data-status="delivered">
                                    <i class="bi bi-check-circle me-1"></i> Mark as Delivered
                                </button>
                            @endif
                            <button type="button" class="btn btn-outline-danger btn-sm status-update" data-status="cancelled">
                                <i class="bi bi-x-circle me-1"></i> Cancel Order
                            </button>
                        @endif
                        
                        <a href="#" class="btn btn-outline-secondary btn-sm mt-2" id="printInvoice">
                            <i class="bi bi-printer me-1"></i> Print Invoice
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Customer Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="small text-muted mb-1">Customer</h6>
                        <div class="d-flex align-items-center">
                            @if($order->user && $order->user->avatar)
                                <img src="{{ asset('storage/' . $order->user->avatar) }}" 
                                     class="rounded-circle me-2" width="32" height="32" 
                                     alt="{{ $order->customer_name }}">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" 
                                     style="width: 32px; height: 32px;">
                                    <i class="bi bi-person"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-medium">{{ $order->customer_name }}</div>
                                <div class="text-muted small">{{ $order->customer_email }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="small text-muted mb-1">Contact</h6>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-telephone me-2 text-muted"></i>
                                <span>{{ $order->customer_phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="small text-muted mb-1">Order Number</h6>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-hash me-2 text-muted"></i>
                                <span>{{ $order->order_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="small text-muted mb-1">Shipping Address</h6>
                        <div class="d-flex">
                            <i class="bi bi-geo-alt me-2 text-muted mt-1"></i>
                            <div>
                                <div>{{ $order->shipping_address_line1 }}</div>
                                @if($order->shipping_address_line2)
                                    <div>{{ $order->shipping_address_line2 }}</div>
                                @endif
                                <div>
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}
                                </div>
                                <div>{{ $order->shipping_country }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($order->billing_address_line1)
                    <div>
                        <h6 class="small text-muted mb-1">Billing Address</h6>
                        <div class="d-flex">
                            <i class="bi bi-credit-card me-2 text-muted mt-1"></i>
                            <div>
                                <div>{{ $order->billing_address_line1 }}</div>
                                @if($order->billing_address_line2)
                                    <div>{{ $order->billing_address_line2 }}</div>
                                @endif
                                <div>
                                    {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}
                                </div>
                                <div>{{ $order->billing_country }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to update this order status to <span id="statusLabel" class="fw-bold"></span>?</p>
                <form id="statusUpdateForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" id="statusInput">
                    <div class="mb-3">
                        <label for="statusNotes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="statusNotes" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmStatusUpdate">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle status update buttons
        const statusUpdateButtons = document.querySelectorAll('.status-update');
        const statusUpdateModal = new bootstrap.Modal(document.getElementById('statusUpdateModal'));
        const statusLabel = document.getElementById('statusLabel');
        const statusInput = document.getElementById('statusInput');
        const statusForm = document.getElementById('statusUpdateForm');
        const confirmBtn = document.getElementById('confirmStatusUpdate');
        
        // Status labels for display
        const statusLabels = {
            'pending': 'Pending',
            'processing': 'Processing',
            'shipped': 'Shipped',
            'delivered': 'Delivered',
            'cancelled': 'Cancelled'
        };
        
        // Handle status update button clicks
        statusUpdateButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const status = this.dataset.status;
                statusLabel.textContent = statusLabels[status] || status;
                statusInput.value = status;
                statusForm.action = '{{ route("admin.orders.update-status", $order->id) }}';
                statusUpdateModal.show();
            });
        });
        
        // Handle confirm status update
        confirmBtn.addEventListener('click', function() {
            const formData = new FormData(statusForm);
            
            fetch(statusForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update status: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the status.');
            });
        });
        
        // Print invoice
        document.getElementById('printInvoice')?.addEventListener('click', function(e) {
            e.preventDefault();
            // You can implement print functionality here
            // For now, just show a message
            alert('Print functionality will be implemented here.');
        });
    });
</script>
@endpush

