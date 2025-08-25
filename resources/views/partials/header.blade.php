<header class="site-header bg-white shadow-sm"> 
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
                <img src="{{ $settings['logo'] }}" alt="Wish-Bakery" class="main-logo">
            </a>

            <!-- Center Section - Navigation -->
            <div class="collapse navbar-collapse order-lg-2" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    @foreach($navigation as $key => $item)
                        {{-- ===================== Mega Menu ===================== --}}
                        @if(isset($item['mega_menu']) && $item['mega_menu'])
                            <li class="nav-item dropdown px-lg-2 mega-menu d-flex align-items-center">
                                <!-- Parent link (navigates) -->
                                <a class="nav-link" href="{{ $item['url'] }}">
                                    {{ strtoupper($item['title']) }}
                                </a>
                                <!-- Dropdown toggle -->
                                <button class="btn dropdown-toggle border-0 bg-transparent p-0 ms-1"
                                        id="{{ $key }}Dropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>

                                <!-- Mega Menu -->
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

                        {{-- ===================== Regular Dropdown ===================== --}}
                        @elseif(isset($item['items']) && count($item['items']) > 0)
                            <li class="nav-item dropdown px-lg-2 d-flex align-items-center">
                                <!-- Parent link -->
                                <a class="nav-link" href="{{ $item['url'] }}">
                                    {{ strtoupper($item['title']) }}
                                </a>
                                <!-- Dropdown toggle -->
                                <button class="btn dropdown-toggle border-0 bg-transparent p-0 ms-1"
                                        id="{{ $key }}Dropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>

                                <!-- Dropdown Menu -->
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

                        {{-- ===================== Simple Link ===================== --}}
                        @else
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
                @auth
                    <div class="dropdown">
                        <a href="#" class="nav-link text-dark position-relative px-3 dropdown-toggle" id="accountDropdown" 
                           data-bs-toggle="dropdown" aria-expanded="false" aria-label="My Account">
                            <i class="fas fa-user fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="accountDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('account') }}">
                                    <i class="fas fa-user-circle me-2"></i> My Account
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('account.orders') }}">
                                    <i class="fas fa-shopping-bag me-2"></i> My Orders
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link text-dark position-relative px-3" aria-label="Login">
                        <i class="fas fa-user fa-lg"></i>
                    </a>
                @endauth

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
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fs-4 fw-bold text-primary" id="searchModalLabel">Search Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{ route('products') }}" method="GET" class="search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control form-control-lg border-end-0 py-3 px-4" name="search"
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
        // Mobile menu toggle
        const mobileMenu = new bootstrap.Offcanvas(document.getElementById('mobileMenu'));

        // Desktop dropdown hover (optional)
        function initDropdowns() {
            const dropdowns = document.querySelectorAll('.dropdown');
            if (window.innerWidth >= 992) {
                dropdowns.forEach(dropdown => {
                    const toggle = dropdown.querySelector('[data-bs-toggle="dropdown"]');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    let timeoutId;

                    dropdown.addEventListener('mouseenter', () => {
                        clearTimeout(timeoutId);
                        const bsDropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
                        bsDropdown.show();
                    });

                    dropdown.addEventListener('mouseleave', () => {
                        timeoutId = setTimeout(() => {
                            const bsDropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
                            bsDropdown.hide();
                        }, 300);
                    });

                    if (menu) {
                        menu.addEventListener('mouseenter', () => clearTimeout(timeoutId));
                        menu.addEventListener('mouseleave', () => {
                            timeoutId = setTimeout(() => {
                                const bsDropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
                                bsDropdown.hide();
                            }, 300);
                        });
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            initDropdowns();
            window.addEventListener('resize', () => initDropdowns());
        });
    </script>
@endpush
