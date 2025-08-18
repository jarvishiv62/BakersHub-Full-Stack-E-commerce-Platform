@extends('layouts.app')

@section('title', 'Home | ' . config('app.name'))

@section('content')

<!-- pudding-section.blade.php -->
<section class="pudding-section mt-5" id="puddingSection">
    <div class="pudding-card" id="puddingCarousel">
        <!-- Slide 1 -->
        <div class="pudding-slide active" data-bg="{{ asset('images/home/hero1.jpg') }}">
            <h2>This Month's Pudding: Cookies and Cream!</h2>
            <p>Our classic vanilla pudding is layered with bananas and Oreo cookies for a dessert that has all the flavors of cookies and cream. Available until August 24th!</p>
            <a href="{{ route('products') }}" class="order-btn">ORDER NOW</a>
        </div>
        
        <!-- Slide 2 -->
        <div class="pudding-slide" data-bg="{{ asset('images/home/hero2.jpg') }}">
            <h2>Special: Chocolate Fudge Delight!</h2>
            <p>Rich chocolate fudge pudding topped with whipped cream and sprinkles. Perfect for chocolate lovers and for all occasions. Limited time only!</p>
            <a href="{{ route('products') }}" class="order-btn">ENQUIRE NOW</a>
        </div>
        
        <!-- Slide 3 -->
        <div class="pudding-slide" data-bg="{{ asset('images/home/hero3.jpg') }}">
            <h2>Seasonal Berry <br>Pudding !</h2>
            <p>Fresh mixed berries with our signature vanilla custard. A refreshing summer treat that's both light and satisfying. Available until september 27th!</p>
            <a href="{{ route('products') }}" class="order-btn">LIMITED TIME ONLY</a>
        </div>
        
        <!-- Slide 4 -->
        <div class="pudding-slide" data-bg="https://images.unsplash.com/photo-1519869325930-281384150729">
            <h2>Caramel Crunch <br>Supreme !</h2>
            <p>Decadent caramel pudding with a crunchy toffee topping. A perfect balance of sweet and salty flavors and for all occasions.</p>
            <a href="{{ route('products') }}" class="order-btn">LIMITED TIME ONLY</a>
        </div>
        
        <!-- Slide 5 -->
        <div class="pudding-slide" data-bg="https://images.unsplash.com/photo-1549007994-cb92caebd54b">
            <h2>Classic Vanilla <br>Bean !</h2>
            <p>Our signature vanilla bean pudding made with real vanilla. Simple, creamy, and absolutely delicious delight for kids and adults alike.</p>
            <a href="{{ route('products') }}" class="order-btn">ORDER NOW</a>
        </div>
        
        <!-- Navigation -->
        <div class="slider-nav">
            <button class="nav-btn" id="prevBtn" aria-label="Previous slide">&#8592;</button>
            <div class="dots">
                <span class="dot active" data-slide="0" aria-label="Slide 1"></span>
                <span class="dot" data-slide="1" aria-label="Slide 2"></span>
                <span class="dot" data-slide="2" aria-label="Slide 3"></span>
                <span class="dot" data-slide="3" aria-label="Slide 4"></span>
                <span class="dot" data-slide="4" aria-label="Slide 5"></span>
            </div>
            <button class="nav-btn" id="nextBtn" aria-label="Next slide">&#8594;</button>
        </div>
    </div>
</section>

    <!-- Products Section -->
    <section class="home-section products-bg text-center py-5">
        <div class="container">
            <div class="section-title">
                <h2>Our Products</h2>
                <p>Handcrafted with love and the finest ingredients, each bite is a celebration of flavor and tradition.</p>
            </div>
            
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <img src="{{ asset($product['image']) }}" class="card-img-top" alt="{{ $product['name'] }}">
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">{{ $product['category'] }}</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $product['name'] }}</h5>
                                <span class="text-dark fw-bold">₹{{ number_format($product['price'], 2) }}</span>
                            </div>
                            <p class="card-text text-muted small">{{ $product['description'] }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 text-center">
                            <button class="btn btn-outline-primary w-100 add-to-cart" data-product-id="{{ $product['id'] }}">
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('products') }}" class="btn btn-view-all">
                    View All Products <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Gift for Any Occasion Section -->
    <section class="home-section gifts-bg text-center">
        <div class="container">
            <div class="section-title">
                <h2>Gift for Any Occasion</h2>
                <p>Perfect treats for every celebration, specially crafted to make your moments memorable.</p>
            </div>
            
            <div class="row g-4">
                @foreach($occasions as $occasion)
                <div class="col-md-6 col-lg-4">
                    <div class="gift-card h-100 position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset($occasion['image']) }}" class="w-100 h-100 object-fit-cover" alt="{{ $occasion['alt'] }}">
                        <div class="gift-overlay d-flex flex-column justify-content-center p-4">
                            <h3 class="text-white fw-bold mb-2">{{ $occasion['title'] }}</h3>
                            <p class="text-dark-50 mb-3">{{ $occasion['description'] }}</p>
                            <a href="{{ route('products') . '?' . parse_url($occasion['route'], PHP_URL_QUERY) }}" class="btn btn-light align-self-center">Explore →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Delivery and Pick Up Options -->
    <section class="home-section delivery-options-bg text-center py-5">
        <div class="container">
            <div class="section-title">
                <h2>Delivery & Pickup</h2>
                <p>We make it easy for you to get Wish Bakery's best, wherever you are</p>
            </div>
            
            <div class="row g-4">
                @foreach($deliveryOptions as $option)
                <div class="col-md-4">
                    <div class="option-card h-100 p-4 p-lg-5 text-center bg-white rounded-4 shadow-sm">
                        <div class="option-icon mb-4">
                            <i class="bi {{ $option['icon'] }} fs-1 text-primary"></i>
                        </div>
                        <h3 class="h4 mb-3">{{ $option['title'] }}</h3>
                        <p class="text-muted mb-4">{{ $option['description'] }}</p>
                        <a href="{{ $option['link'] }}" class="btn btn-outline-primary">{{ $option['linkText'] }}</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Carousel -->
    <section class="testimonials-bg py-5" aria-label="Customer Testimonials">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-5 fw-bold mb-3 text-center">What Our Customers Say</h2>
                <p class="lead text-muted text-center">Hear from people who love our bakery</p>
            </div>
            
            @if(count($testimonials) > 0)
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="8000">
                <!-- Slides -->
                <div class="carousel-inner">
                    @php
                        // Get all active testimonials ordered by creation date
                        $testimonialsArray = $testimonials->sortBy('created_at')->values()->all();
                        // Split into chunks of 2 testimonials each
                        $chunks = array_chunk($testimonialsArray, 2);
                    @endphp
                    
                    @foreach($chunks as $index => $chunk)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="8000">
                        <div class="row g-4">
                            @foreach($chunk as $testimonial)
                            <div class="col-md-6">
                                <div class="testimonial-card h-100">
                                    <div class="testimonial-content">
                                        <div class="rating mb-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $testimonial['rating'] ? '-fill' : '' }} {{ $i <= $testimonial['rating'] ? 'text-warning' : 'text-light' }}"></i>
                                            @endfor
                                            <span class="visually-hidden">Rating: {{ $testimonial['rating'] }} out of 5 stars</span>
                                        </div>
                                        
                                        <div class="testimonial-text">
                                            "{{ $testimonial['quote'] }}"
                                        </div>
                                        
                                        <div class="testimonial-author mt-3">
                                            <div class="author-icon">
                                                <i class="bi bi-person-circle fs-3 text-primary"></i>
                                            </div>
                                            <div class="author-info">
                                                <h6 class="mb-0 fw-bold">{{ $testimonial['name'] }}</h6>
                                                <p class="text-muted small mb-0">{{ $testimonial['role'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Controls -->
                @if(count($testimonials) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous testimonial</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next testimonial</span>
                </button>
                @endif
            </div>
            @else
            <div class="text-center py-5">
                <div class="alert alert-info">
                    <p class="mb-0">No testimonials available at the moment. Check back soon!</p>
                </div>
            </div>
            @endif
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.pudding-slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const puddingSection = document.getElementById('puddingSection');
    let currentIndex = 0;
    let slideInterval;
    const SLIDE_INTERVAL = 5000; // 5 seconds

    // Initialize the slider
    function initSlider() {
        // Set initial slide
        showSlide(0);
        
        // Start auto-slide
        startAutoSlide();
        
        // Pause auto-slide on hover
        const slider = document.querySelector('.pudding-card');
        slider.addEventListener('mouseenter', pauseAutoSlide);
        slider.addEventListener('mouseleave', startAutoSlide);
        
        // Touch events for mobile swipe
        let touchStartX = 0;
        let touchEndX = 0;
        
        slider.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
            pauseAutoSlide();
        }, { passive: true });
        
        slider.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startAutoSlide();
        }, { passive: true });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }
    }
    
    // Show specific slide
    function showSlide(index) {
        // Update current index
        currentIndex = (index + slides.length) % slides.length;
        
        // Update slides
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === currentIndex);
        });
        
        // Update dots
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
            dot.setAttribute('aria-selected', i === currentIndex);
        });
        
        // Update background image with fade effect
        if (slides[currentIndex].dataset.bg) {
            puddingSection.style.backgroundImage = `url('${slides[currentIndex].dataset.bg}')`;
        }
    }
    
    // Navigation functions
    function nextSlide() {
        showSlide(currentIndex + 1);
    }
    
    function prevSlide() {
        showSlide(currentIndex - 1);
    }
    
    // Auto-slide functionality
    function startAutoSlide() {
        clearInterval(slideInterval);
        slideInterval = setInterval(() => {
            nextSlide();
        }, SLIDE_INTERVAL);
    }
    
    function pauseAutoSlide() {
        clearInterval(slideInterval);
    }
    
    // Event listeners
    prevBtn.addEventListener('click', () => {
        prevSlide();
        pauseAutoSlide();
        startAutoSlide();
    });
    
    nextBtn.addEventListener('click', () => {
        nextSlide();
        pauseAutoSlide();
        startAutoSlide();
    });
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            pauseAutoSlide();
            startAutoSlide();
        });
        
        // Keyboard accessibility for dots
        dot.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                showSlide(index);
                pauseAutoSlide();
                startAutoSlide();
            }
        });
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevSlide();
            pauseAutoSlide();
            startAutoSlide();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            pauseAutoSlide();
            startAutoSlide();
        }
    });
    
    // Initialize the slider
    initSlider();
});
</script>
@endpush
