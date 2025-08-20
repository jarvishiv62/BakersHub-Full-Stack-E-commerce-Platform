<header class="site-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ url('/') }}" aria-label="Home">
                <img src="{{ $settings['logo'] }}" alt="{{ $settings['site_name'] }}" class="main-logo">
            </a>

            <!-- Mobile Menu Toggle, Login & Cart -->
            <div class="d-flex align-items-center order-lg-3">
                @guest
                    <a href="{{ route('login') }}" class="nav-icon me-3" aria-label="Login">
                        <i class="fas fa-user" aria-hidden="true"></i>
                    </a>
                @else
                    <a href="{{ route('account') }}" class="nav-icon me-3" aria-label="My Account">
                        <i class="fas fa-user" aria-hidden="true"></i>
                    </a>
                @endguest
                
                <a href="{{ route('cart') }}" class="nav-icon cart-icon position-relative me-3" aria-label="Shopping Cart">
                    <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                    @if($settings['cart_count'] > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                            {{ $settings['cart_count'] }}
                        </span>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#mainNav" 
                        aria-controls="mainNav" 
                        aria-expanded="false" 
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Main Navigation Menu -->
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto main-nav">
                    @foreach($navigation as $key => $item)
                        @php
                            $hasDropdown = isset($item['items']) || isset($item['columns']);
                            $isMegaMenu = $hasDropdown && ($item['mega_menu'] ?? false);
                        @endphp
                        
                        <li class="nav-item {{ $isMegaMenu ? 'mega-dropdown' : 'dropdown' }}">
                            <a class="nav-link dropdown-toggle" 
                               href="{{ $item['url'] }}" 
                               id="{{ $key }}Dropdown" 
                               role="button" 
                               data-bs-toggle="{{ $hasDropdown ? 'dropdown' : '' }}" 
                               aria-expanded="false" 
                               aria-haspopup="{{ $hasDropdown ? 'true' : 'false' }}"
                               {{ $hasDropdown ? 'data-has-dropdown="true"' : '' }}>
                                <h4>{{ $item['title'] }}</h4>
                            </a>

                            @if($hasDropdown)
                                @if($isMegaMenu)
                                    <div class="dropdown-menu mega-menu" aria-labelledby="{{ $key }}Dropdown" data-bs-auto-close="outside">
                                        <div class="container">
                                            <div class="row g-4">
                                                @foreach($item['columns'] as $column)
                                                    <div class="col-lg-3">
                                                        <h5 class="mega-menu-title">{{ $column['title'] }}</h5>
                                                        <ul class="mega-menu-list">
                                                            @foreach($column['items'] as $subItem)
                                                                @if(!isset($subItem['auth']) || (auth()->check() && $subItem['auth']))
                                                                    <li><a href="{{ $subItem['url'] }}">{{ $subItem['name'] }}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if(isset($item['view_all']))
                                                <div class="row mt-4">
                                                    <div class="col-12 text-center">
                                                        <a href="{{ $item['url'] }}" class="btn btn-outline-dark">
                                                            View All {{ $item['title'] }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <ul class="dropdown-menu" aria-labelledby="{{ $key }}Dropdown">
                                        @foreach($item['items'] as $subItem)
                                            @if((!isset($subItem['auth']) && !isset($subItem['guest'])) || 
                                                (auth()->check() && isset($subItem['auth'])) ||
                                                (!auth()->check() && isset($subItem['guest'])))
                                                <li>
                                                    @if(isset($subItem['divider']))
                                                        <hr class="dropdown-divider">
                                                    @else
                                                        <a class="dropdown-item" href="{{ $subItem['url'] }}">
                                                            {{ $subItem['name'] }}
                                                        </a>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</header>

@push('scripts')
<script>
(function() {
    // Wait for DOM and all scripts to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize dropdowns after a small delay to ensure Bootstrap is loaded
        setTimeout(initializeDropdowns, 100);
    });

    let hoverTimeout;
    
    function initializeDropdowns() {
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        
        // Initialize all dropdowns
        dropdownToggles.forEach(toggle => {
            // Initialize Bootstrap dropdown
            const dropdown = new bootstrap.Dropdown(toggle, {
                autoClose: true,
                popperConfig: (defaultConfig) => ({
                    ...defaultConfig,
                    strategy: 'fixed'
                })
            });
            
            // Add click handler for mobile
            toggle.addEventListener('click', handleMobileClick);
        });
        
        // Add event listeners for desktop hover
        if (window.innerWidth > 991.98) {
            document.addEventListener('mouseover', handleDesktopHover);
            document.addEventListener('mouseout', handleDesktopLeave);
            document.addEventListener('click', handleDesktopClickOutside);
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            // Re-initialize event listeners when crossing the breakpoint
            if (window.innerWidth > 991.98) {
                document.addEventListener('mouseover', handleDesktopHover);
                document.addEventListener('mouseout', handleDesktopLeave);
                document.addEventListener('click', handleDesktopClickOutside);
            } else {
                document.removeEventListener('mouseover', handleDesktopHover);
                document.removeEventListener('mouseout', handleDesktopLeave);
                document.removeEventListener('click', handleDesktopClickOutside);
            }
        });

        // Handle scroll effect for header
        function handleScroll() {
            const header = document.querySelector('.site-header');
            if (!header) return;
            
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }

        // Initialize scroll handler
        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Call once on load
    }
    
    // Desktop hover handlers
    function handleDesktopHover(e) {
        clearTimeout(hoverTimeout);
        const dropdown = e.target.closest('.dropdown');
        if (!dropdown) return;
        
        const toggle = dropdown.querySelector('[data-bs-toggle="dropdown"]');
        if (!toggle) return;
        
        // Hide current dropdown if different
        if (window.currentDropdown && window.currentDropdown !== dropdown) {
            const currentToggle = window.currentDropdown.querySelector('[data-bs-toggle="dropdown"]');
            if (currentToggle) {
                const bsDropdown = bootstrap.Dropdown.getInstance(currentToggle);
                if (bsDropdown) bsDropdown.hide();
            }
        }
        
        // Show new dropdown
        const bsDropdown = bootstrap.Dropdown.getInstance(toggle) || new bootstrap.Dropdown(toggle);
        if (bsDropdown) {
            bsDropdown.show();
            window.currentDropdown = dropdown;
        }
    }
    
    function handleDesktopLeave(e) {
        const dropdown = e.target.closest('.dropdown');
        if (!dropdown || !window.currentDropdown) return;
        
        const relatedTarget = e.relatedTarget || e.toElement;
        if (relatedTarget && dropdown.contains(relatedTarget)) return;
        
        hoverTimeout = setTimeout(() => {
            const toggle = window.currentDropdown?.querySelector('[data-bs-toggle="dropdown"]');
            if (toggle) {
                const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                if (bsDropdown && !toggle.matches(':hover')) {
                    bsDropdown.hide();
                    window.currentDropdown = null;
                }
            }
        }, 100);
    }
    
    function handleDesktopClickOutside(e) {
        if (!e.target.closest('.dropdown-menu') && !e.target.closest('[data-bs-toggle="dropdown"]')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                const toggle = menu.previousElementSibling;
                if (toggle) {
                    const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                    if (bsDropdown) bsDropdown.hide();
                }
            });
        }
    }
    
    // Mobile click handler
    function handleMobileClick(e) {
        if (window.innerWidth > 991.98) return;
        
        const toggle = e.target.closest('[data-bs-toggle="dropdown"]');
        if (!toggle) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const bsDropdown = bootstrap.Dropdown.getInstance(toggle) || new bootstrap.Dropdown(toggle);
        
        if (toggle.getAttribute('aria-expanded') === 'true') {
            bsDropdown.hide();
        } else {
            // Hide other open dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                const otherToggle = menu.previousElementSibling;
                if (otherToggle && otherToggle !== toggle) {
                    const otherDropdown = bootstrap.Dropdown.getInstance(otherToggle);
                    if (otherDropdown) otherDropdown.hide();
                }
            });
            bsDropdown.show();
        }
    }
})();
</script>
@endpush
