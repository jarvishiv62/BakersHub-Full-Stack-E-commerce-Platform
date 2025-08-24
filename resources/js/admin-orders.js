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
            // Show success message
            alert(`Order status updated to ${status.charAt(0).toUpperCase() + status.slice(1)}`);
            // Reload the page to reflect changes
            window.location.reload();
        } else {
            throw new Error(data.message || 'Failed to update order status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'An error occurred while updating the order status');
    });
}

// Initialize data-tables if present
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTables if available
    if ($.fn.DataTable) {
        $('.data-table').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center mb-3"f<"d-flex align-items-center"><"d-flex align-items-center">>rt<"d-flex justify-content-between align-items-center"ip>',
            language: {
                search: "",
                searchPlaceholder: "Search orders...",
                lengthMenu: "_MENU_"
            }
        });
    }
});
