@extends('layouts.app')

@section('title', 'Account | ' . config('app.name'))

@section('content')
<div class="container">
    <!-- Welcome Header -->
    <div class="row mb-4 text-center py-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold text-chocolate mb-2">Welcome back!</h1>
            <p class="lead text-muted">Here's your sweet little dashboard</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mx-auto">
            <!-- Profile Information Section -->
            <section class="account-section mb-5">
                <div class="section-header">
                    <i class="fas fa-user-circle me-2"></i>
                    <h2>Profile Information</h2>
                </div>
                <div class="section-content bg-white">
                    <form id="profileForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="#" class="rounded-circle img-thumbnail" width="150" height="150" alt="Profile Picture">
                                    <label class="btn btn-sm btn-vanilla position-absolute bottom-0 end-0 rounded-circle" style="width: 40px; height: 40px;" title="Change Photo">
                                        <i class="fas fa-camera"></i>
                                        <input type="file" class="d-none" id="profilePicture" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="address" class="form-label">Delivery Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-chocolate text-white">
                                            <i class="fas fa-save me-2"></i>Save Changes
                                        </button>
                                        <button type="button" class="btn btn-outline-chocolate ms-2" data-bs-toggle="collapse" data-bs-target="#passwordCollapse" aria-expanded="false" aria-controls="passwordCollapse">
                                            Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Section -->
                        <div class="collapse mt-4" id="passwordCollapse">
                            <hr>
                            <h5 class="mb-4">Change Password</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword">
                                </div>
                                <div class="col-md-4">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword">
                                </div>
                                <div class="col-md-4">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword">
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-chocolate text-white" id="updatePassword">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <!-- My Orders Section -->
            <section class="account-section">
                <div class="section-header">
                    <i class="fas fa-shopping-bag me-2"></i>
                    <h2>My Orders</h2>
                </div>
                <div class="section-content bg-white">
                    @if(isset($orders) && count($orders) > 0)
                        @foreach($orders as $order)
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <h6 class="mb-1">Order #{{ $order['id'] }}</h6>
                                            <small class="text-muted">Placed on {{ $order['date'] }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="badge bg-{{ $order['status'] == 'completed' ? 'success' : ($order['status'] == 'processing' ? 'warning' : 'secondary') }} text-capitalize">
                                                {{ $order['status'] }}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <h6 class="mb-0">${{ number_format($order['total'], 2) }}</h6>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button class="btn btn-sm btn-outline-chocolate view-order-details" data-bs-toggle="modal" data-bs-target="#orderDetailsModal" data-order-id="{{ $order['id'] }}">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-order.svg') }}" alt="No Orders" class="img-fluid mb-3" style="max-width: 200px;">
                            <h5 class="text-muted">No orders yet</h5>
                            <p class="text-muted">Your order history will appear here</p>
                            <a href="{{ route('products') }}" class="btn btn-chocolate text-white">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light-brown">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details #<span id="orderId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <p class="mb-1"><strong>Order Date:</strong> <span id="orderDate"></span></p>
                        <p class="mb-1"><strong>Status:</strong> <span id="orderStatus" class="badge"></span></p>
                        <p class="mb-1"><strong>Payment Method:</strong> <span id="paymentMethod"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Delivery Address</h6>
                        <p id="deliveryAddress" class="mb-0"></p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody id="orderItems">
                            <!-- Order items will be inserted here by JavaScript -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                <td class="text-end" id="subtotal"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Shipping:</td>
                                <td class="text-end" id="shipping">$5.99</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold" id="orderTotal"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-chocolate text-white" id="reorderBtn">
                    <i class="fas fa-redo me-2"></i>Reorder
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle profile picture preview
    const profilePictureInput = document.getElementById('profilePicture');
    const profilePicture = document.querySelector('.img-thumbnail');
    
    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profilePicture.src = event.target.result;
                    // Here you would typically upload the image to the server
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    // Handle form submission
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Collect form data
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                _token: '{{ csrf_token() }}'
            };

            // Here you would typically send this data to your server
            console.log('Form submitted:', formData);
            
            // Show success message
            showAlert('Profile updated successfully!', 'success');
        });
    }

    // Handle password update
    const updatePasswordBtn = document.getElementById('updatePassword');
    if (updatePasswordBtn) {
        updatePasswordBtn.addEventListener('click', function() {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                showAlert('New passwords do not match!', 'danger');
                return;
            }

            // Here you would typically send this to your server to update the password
            console.log('Updating password...');
            
            // Show success message
            showAlert('Password updated successfully!', 'success');
            
            // Clear password fields
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
            
            // Close the password section
            const passwordCollapse = new bootstrap.Collapse(document.getElementById('passwordCollapse'), {
                toggle: false
            });
            passwordCollapse.hide();
        });
    }
});

// Helper function to show alerts
function showAlert(message, type) {
    // Remove any existing alerts
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }

    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.role = 'alert';
    alertDiv.style.zIndex = '1100';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Add to body
    document.body.appendChild(alertDiv);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 5000);
}
</script>
@endpush
