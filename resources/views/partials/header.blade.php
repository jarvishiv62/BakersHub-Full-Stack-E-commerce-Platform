<header class="site-header sticky-top bg-white shadow-sm">
    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Left Section - Logo -->
            <a class="navbar-brand mx-lg-0 mx-auto order-lg-1" href="{{ url('/') }}">
                <img src="{{ $settings['logo'] }}" alt="Wish-Bakery" height="50">
                <small class="d-block text-center text-muted fst-italic">EST. 1996</small>
            </a>

            <!-- Center Section - Navigation -->
            <div class="collapse navbar-collapse order-lg-2" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    @foreach($navigation as $key => $item)
                        @if(isset($item['mega_menu']) && $item['mega_menu'])
                            <!-- Mega Menu -->
                            <li class="nav-item dropdown px-lg-2 mega-menu">
                                <a class="nav-link dropdown-toggle" href="{{ $item['url'] }}" id="{{ $key }}Dropdown"
                                    role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    {{ strtoupper($item['title']) }}
                                </a>
                                <div class="dropdown-menu dropdown-mega border-0 shadow p-4"
                                    aria-labelledby="{{ $key }}Dropdown"
                                    style="min-width: 750px; left: 50%; transform: translateX(-50%);">
                                    <div class="container-fluid">
                                        <div class="row g-4">
                                            @foreach($item['columns'] as $column)
                                                <div class="col-md-4">
                                                    @if(isset($column['title']))
                                                        <h6 class="dropdown-header fw-bold text-uppercase text-primary mb-2">
                                                            {{ $column['title'] }}
                                                        </h6>
                                                    @endif
                                                    @if(isset($column['items']))
                                                        <div class="d-flex flex-column">
                                                            @foreach($column['items'] as $subItem)
                                                                @if(!isset($subItem['auth']) || (isset($subItem['auth']) && auth()->check()))
                                                                    <a class="dropdown-item px-3 py-2 rounded-3 mb-1"
                                                                        href="{{ $subItem['url'] }}">
                                                                        <i class="bi bi-chevron-right me-2 text-muted"></i>
                                                                        {{ $subItem['name'] }}
                                                                    </a>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @if(isset($column['image']))
                                                        <div class="mt-3">
                                                            <img src="{{ $column['image'] }}" alt=""
                                                                class="img-fluid rounded shadow-sm">
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @elseif(isset($item['items']) && count($item['items']) > 0)
                            <!-- Regular Dropdown -->
                            <li class="nav-item dropdown px-lg-2">
                                <a class="nav-link dropdown-toggle" href="{{ $item['url'] }}" id="{{ $key }}Dropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ strtoupper($item['title']) }}
                                </a>
                                <ul class="dropdown-menu border-0 shadow" aria-labelledby="{{ $key }}Dropdown">
                                    @foreach($item['items'] as $subItem)
                                        @if(
                                                (!isset($subItem['auth']) || (isset($subItem['auth']) && auth()->check())) &&
                                                (!isset($subItem['guest']) || (isset($subItem['guest']) && !auth()->check()))
                                            )
                                            <li>
                                                <a class="dropdown-item" href="{{ $subItem['url'] }}">
                                                    {{ $subItem['name'] }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <!-- Simple Link -->
                            <li class="nav-item px-lg-2">
                                <a class="nav-link" href="{{ $item['url'] }}">
                                    {{ strtoupper($item['title']) }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Right Section - Icons and Button -->
            <div class="d-flex align-items-center order-lg-3 ms-lg-4">
                <!-- Account -->
                <a href="{{ auth()->check() ? route('account') : route('login') }}"
                    class="nav-link text-dark position-relative px-3" aria-label="Account">
                    <i class="fas fa-user fa-lg"></i>
                </a>

                <!-- Search -->
                <a href="#" class="nav-link text-dark px-3" aria-label="Search" data-bs-toggle="modal"
                    data-bs-target="#searchModal">
                    <i class="fas fa-search fa-lg"></i>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="nav-link text-dark position-relative px-3"
                    aria-label="Shopping Cart">
                    <i class="fas fa-shopping-bag fa-lg"></i>
                    @if(isset($settings['cart_count']) && $settings['cart_count'] > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6rem; padding: 0.25rem 0.4rem;">
                            {{ $settings['cart_count'] }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>
</header>

<!-- Mobile Menu -->
<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            @foreach($navigation as $key => $item)
                @if(isset($item['items']) && count($item['items']) > 0)
                    <li class="nav-item border-bottom">
                        <a class="nav-link px-0 py-3 d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#mobile{{ ucfirst($key) }}Collapse" role="button"
                            aria-expanded="false" aria-controls="mobile{{ ucfirst($key) }}Collapse">
                            {{ strtoupper($item['title']) }}
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <div class="collapse" id="mobile{{ ucfirst($key) }}Collapse">
                            <ul class="list-unstyled ps-3 py-2">
                                @if(isset($item['columns']))
                                    @foreach($item['columns'] as $column)
                                        @if(isset($column['items']))
                                            @foreach($column['items'] as $subItem)
                                                @if(!isset($subItem['auth']) || (isset($subItem['auth']) && auth()->check()))
                                                    <li>
                                                        <a href="{{ $subItem['url'] }}" class="text-decoration-none d-block py-2">
                                                            {{ $subItem['name'] }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($item['items'] as $subItem)
                                        @if(
                                                (!isset($subItem['auth']) || (isset($subItem['auth']) && auth()->check())) &&
                                                (!isset($subItem['guest']) || (isset($subItem['guest']) && !auth()->check()))
                                            )
                                            <li>
                                                <a href="{{ $subItem['url'] }}" class="text-decoration-none d-block py-2">
                                                    {{ $subItem['name'] }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item border-bottom">
                        <a class="nav-link px-0 py-3" href="{{ $item['url'] }}">
                            {{ strtoupper($item['title']) }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fs-4 fw-bold text-primary" id="searchModalLabel">Search Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{ route('search') }}" method="GET" class="search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control form-control-lg border-end-0 py-3 px-4" name="q"
                            placeholder="What are you looking for?" aria-label="Search products" required>
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // Mobile menu toggle functionality
        const mobileMenu = new bootstrap.Offcanvas(document.getElementById('mobileMenu'));

        // Initialize dropdowns with hover functionality for desktop
        function initDropdowns() {
            const dropdowns = document.querySelectorAll('.dropdown');

            // Only add hover functionality on desktop
            if (window.innerWidth >= 992) {
                dropdowns.forEach(dropdown => {
                    const toggle = dropdown.querySelector('.dropdown-toggle');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    let timeoutId;

                    // Show on hover
                    dropdown.addEventListener('mouseenter', () => {
                        clearTimeout(timeoutId);
                        const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                        if (bsDropdown) {
                            bsDropdown.show();
                        }
                    });

                    // Hide with delay
                    dropdown.addEventListener('mouseleave', () => {
                        timeoutId = setTimeout(() => {
                            const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                            if (bsDropdown) {
                                bsDropdown.hide();
                            }
                        }, 300); // 300ms delay before hiding
                    });

                    // Keep menu open when hovering over it
                    if (menu) {
                        menu.addEventListener('mouseenter', () => clearTimeout(timeoutId));
                        menu.addEventListener('mouseleave', () => {
                            timeoutId = setTimeout(() => {
                                const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                                if (bsDropdown) {
                                    bsDropdown.hide();
                                }
                            }, 300);
                        });
                    }
                });
            }
        }

        // Initialize all components when DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize dropdowns
            const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl, {
                    autoClose: true,
                    popperConfig: (defaultConfig) => ({
                        ...defaultConfig,
                        strategy: 'fixed'
                    })
                });
            });

            // Initialize hover functionality
            initDropdowns();

            // Re-initialize on window resize
            let resizeTimer;
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(initDropdowns, 250);
            });
        });

        // Search modal toggle
        document.querySelectorAll('[data-bs-toggle="search"]').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const searchModal = new bootstrap.Modal(document.getElementById('searchModal'));
                searchModal.show();
            });
        });
    </script>
@endpush