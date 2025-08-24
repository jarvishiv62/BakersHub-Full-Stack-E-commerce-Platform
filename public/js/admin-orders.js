document.addEventListener('DOMContentLoaded', function() {
    // Status update handling
    document.querySelectorAll('.status-update').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.dataset.id;
            const newStatus = this.dataset.status;
            
            if (confirm(`Are you sure you want to mark this order as ${newStatus}?`)) {
                updateOrderStatus(orderId, newStatus);
            }
        });
    });

    // Status filter
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const status = this.value;
            const url = new URL(window.location.href);
            
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            
            window.location.href = url.toString();
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        let searchTimer;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            const searchTerm = this.value.trim();
            
            searchTimer = setTimeout(() => {
                const url = new URL(window.location.href);
                
                if (searchTerm) {
                    url.searchParams.set('search', searchTerm);
                } else {
                    url.searchParams.delete('search');
                }
                
                window.location.href = url.toString();
            }, 500);
        });
    }
});

// Update order status via AJAX
function updateOrderStatus(orderId, status) {
    const url = `/admin/orders/${orderId}/status`;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            status: status,
            _token: token
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update the status badge directly in the DOM
            const statusBadge = document.querySelector(`.status-badge[data-order-id="${orderId}"]`);
            if (statusBadge) {
                // Update the status text
                statusBadge.textContent = data.status_label;
                
                // Update the status data attribute
                statusBadge.dataset.status = data.status;
                
                // Update the badge color based on status
                const statusClasses = ['bg-warning', 'bg-info', 'bg-primary', 'bg-success', 'bg-danger'];
                statusBadge.classList.remove(...statusClasses);
                
                switch(data.status) {
                    case 'pending':
                        statusBadge.classList.add('bg-warning');
                        break;
                    case 'processing':
                        statusBadge.classList.add('bg-info');
                        break;
                    case 'shipped':
                        statusBadge.classList.add('bg-primary');
                        break;
                    case 'delivered':
                        statusBadge.classList.add('bg-success');
                        break;
                    case 'cancelled':
                        statusBadge.classList.add('bg-danger');
                        break;
                }
            }
            
            // Show success message
            alert(`Order status updated to ${data.status_label}`);
        } else {
            throw new Error(data.message || 'Failed to update order status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'An error occurred while updating the order status');
    });
}

// Initialize DataTable if not already initialized
document.addEventListener('DOMContentLoaded', function() {
    // Check if DataTable is available and the table exists
    if ($.fn.DataTable && $('#ordersTable').length && !$.fn.DataTable.isDataTable('#ordersTable')) {
        const table = $('#ordersTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[2, 'desc']], // Sort by date column (3rd column, 0-indexed)
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "",
                searchPlaceholder: "Search orders...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered from _MAX_ total entries)"
            },
            initComplete: function() {
                // Apply the status filter
                $('#statusFilter').on('change', function() {
                    const status = $(this).val();
                    if (status) {
                        table.column(3).search('^' + status + '$', true, false).draw();
                    } else {
                        table.column(3).search('').draw();
                    }
                });
            }
        });
    }
});
