@extends('layouts.app')

@section('title', $meta['title'] ?? 'About Us | ' . config('app.name'))

@push('meta')
<meta name="description" content="{{ $meta['description'] ?? '' }}">
@endpush

@section('content')
<!-- Hero Section -->
<section class="about-hero position-relative d-flex align-items-center">
    <div class="container position-relative z-index-1">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <img src="/images/catering/logohead.webp" class="img-fluid" alt="{{ config('app.name') }}">
                <h1 class="display-3 fw-bold text-white mb-4" data-aos="fade-up">{{ $hero['title'] }}</h1>
                <p class="lead text-white mb-4" data-aos="fade-up" data-aos-delay="100">{{ $hero['subtitle'] }}</p>
                <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="200">
                    @foreach($hero['buttons'] as $button)
                        <a href="{{ isset($button['route']) ? route($button['route']) : $button['url'] }}" 
                           class="btn {{ $button['class'] }} btn-lg px-4">
                            @if(isset($button['icon']))
                                <i class="{{ $button['icon'] }} me-2"></i>
                            @endif
                            {{ $button['text'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
@if(isset($timeline) && !empty($timeline['items']))
<section id="our-story" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">{{ $timeline['title'] }}</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">{{ $timeline['subtitle'] }}</p>
            </div>
        </div>
        
        <div class="timeline">
            @foreach($timeline['items'] as $index => $item)
            <div class="timeline-container {{ $item['position'] ?? ($index % 2 == 0 ? 'left' : 'right') }}" 
                 data-aos="fade-{{ $item['position'] === 'right' ? 'left' : 'right' }}">
                <div class="timeline-content">
                    <div class="timeline-icon">
                        <i class="fas {{ $item['icon'] }}"></i>
                    </div>
                    <h3>{{ $item['year'] }}</h3>
                    <h4>{{ $item['title'] }}</h4>
                    <p>{{ $item['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Bakers Section -->
@if(isset($bakers) && !empty($bakers['team']))
<section id="meet-bakers" class="py-5">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">{{ $bakers['title'] }}</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">{{ $bakers['subtitle'] }}</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($bakers['team'] as $baker)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $baker['delay'] ?? '100' }}">
                <div class="baker-card">
                    <div class="baker-img">
                        <img src="{{ asset('images/aboutimg/' . $baker['image']) }}" alt="{{ $baker['name'] }}" class="img-fluid">
                    </div>
                    <div class="baker-info">
                        <h4>{{ $baker['name'] }}</h4>
                        <p class="text-muted">{{ $baker['role'] }}</p>
                        <div class="baker-social">
                            @foreach($baker['social'] as $platform => $url)
                                @if($url)
                                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-{{ $platform }}"></i>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="baker-hover">
                        <h5>Fun Fact</h5>
                        <p>{{ $baker['fun_fact'] }}</p>
                        <div class="baker-specialty">
                            <i class="fas fa-star"></i>
                            <span>Specialty: {{ $baker['specialty'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Awards Section -->
@if(isset($awards) && !empty($awards['slides']))
<section id="awards" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">{{ $awards['title'] }}</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">{{ $awards['subtitle'] }}</p>
            </div>
        </div>
        
        <div id="awardsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($awards['slides'] as $slideIndex => $slide)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row g-4 justify-content-center">
                        @foreach($slide as $award)
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $award['delay'] ?? '100' }}">
                            <div class="award-card">
                                <div class="award-icon">
                                    <i class="fas fa-{{ $award['icon'] }}"></i>
                                </div>
                                <h4>{{ $award['title'] }}</h4>
                                <p class="text-muted">{{ $award['issuer'] }}</p>
                                <p>{{ $award['description'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#awardsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#awardsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            
            <!-- Indicators -->
            <div class="carousel-indicators position-relative mt-4">
                @foreach($awards['slides'] as $index => $slide)
                <button type="button" data-bs-target="#awardsCarousel" data-bs-slide-to="{{ $index }}" 
                        class="{{ $loop->first ? 'active' : '' }}" 
                        aria-current="{{ $loop->first ? 'true' : 'false' }}" 
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Signature Creations Section -->
@if(isset($signature_creations) && !empty($signature_creations['items']))
<section id="signature-creations" class="py-5 position-relative overflow-hidden">
    <div class="parallax-bg"></div>
    <div class="container position-relative">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="display-5 fw-bold mb-3 text-white" data-aos="fade-up">{{ $signature_creations['title'] }}</h2>
                <p class="lead text-white-50" data-aos="fade-up" data-aos-delay="100">{{ $signature_creations['subtitle'] }}</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($signature_creations['items'] as $item)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $item['delay'] ?? '100' }}">
                <div class="creation-card">
                    <div class="creation-img">
                        <img src="{{ asset('images/aboutimg/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid">
                        <div class="creation-overlay">
                            <div class="creation-content">
                                <h4>{{ $item['name'] }}</h4>
                                <p>{{ $item['description'] }}</p>
                                <a href="#" class="btn btn-outline-light btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="creation-info">
                        <h4>{{ $item['name'] }}</h4>
                        <div class="creation-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($item['rating']))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $item['rating'])
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span>({{ $item['review_count'] }})</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Fun Facts Section -->
@if(isset($fun_facts) && !empty($fun_facts['facts']))
<section id="fun-facts" class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="section-subtitle">Did You Know?</span>
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">{{ $fun_facts['title'] }}</h2>
                <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">{{ $fun_facts['subtitle'] }}</p>
            </div>
        </div>
        
        <div class="row g-4 text-center">
            @foreach($fun_facts['facts'] as $fact)
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ $fact['delay'] ?? '100' }}">
                <div class="fact-item">
                    <div class="fact-icon">
                        <i class="fas fa-{{ $fact['icon'] }}"></i>
                    </div>
                    <div class="fact-number counter" data-count="{{ $fact['count'] }}">0</div>
                    <h4 class="fact-title">{{ $fact['title'] }}</h4>
                    <p class="fact-desc">{{ $fact['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Instagram Section -->
@if(isset($instagram) && !empty($instagram['posts']))
<section id="instagram-feed" class="py-5">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="section-subtitle">Follow Us</span>
                <h2 class="display-5 fw-bold mb-3" data-aos="fade-up">{{ $instagram['title'] }}</h2>
                <p class="lead text-muted mb-4" data-aos="fade-up" data-aos-delay="100">{{ $instagram['subtitle'] }}</p>
                <a href="https://www.instagram.com/{{ $instagram['handle'] }}" target="_blank" 
                   class="btn btn-instagram mb-5" data-aos="fade-up" data-aos-delay="200">
                    <i class="fab fa-instagram me-2"></i> {{ $instagram['button']['text'] ?? 'Follow Us' }}
                </a>
            </div>
        </div>
        
        <div class="row g-0 instagram-grid">
            @foreach($instagram['posts'] as $post)
            <div class="col-6 col-md-4 col-lg-2 instagram-item" data-aos="fade-up" data-aos-delay="{{ $post['delay'] ?? '0' }}">
                <div class="instagram-post">
                    <img src="{{ asset('images/aboutimg/' . $post['image']) }}" alt="Instagram Post" class="img-fluid">
                    <div class="instagram-overlay">
                        <div class="instagram-likes">
                            <i class="fas fa-heart me-1"></i> {{ number_format($post['likes']) }}
                        </div>
                        <div class="instagram-comments">
                            <i class="fas fa-comment me-1"></i> {{ $post['comments'] }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Trust Badges Section -->
@if(isset($trust_badges) && !empty($trust_badges))
<div class="trust-badges mt-5 pt-4 text-center">
    <div class="row g-4 justify-content-center">
        @foreach($trust_badges as $badge)
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ $badge['delay'] ?? '100' }}">
            <div class="trust-badge">
                <i class="fas fa-{{ $badge['icon'] }}"></i>
                <h5>{{ $badge['title'] }}</h5>
                <p>{{ $badge['description'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to check if an element is in the viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Function to animate the counter
    function animateCounter(element, target) {
        const duration = 2000; // Animation duration in milliseconds
        const step = target / (duration / 16); // 60fps
        let current = 0;
        
        // Add a small delay before starting the animation
        setTimeout(() => {
            const updateCounter = () => {
                current += step;
                if (current < target) {
                    // Add comma as thousand separator
                    element.textContent = Math.ceil(current).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target.toLocaleString();
                }
            };
            
            updateCounter();
            element.classList.add('animated');
        }, 200);
    }

    // Function to handle scroll events
    function handleScroll() {
        const counters = document.querySelectorAll('.fact-number');
        
        counters.forEach(counter => {
            if (isInViewport(counter) && !counter.classList.contains('animated')) {
                const target = parseInt(counter.getAttribute('data-count'));
                animateCounter(counter, target);
            }
        });
    }

    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-in-out'
        });
    }

    // Add scroll event listener for counter animation
    window.addEventListener('scroll', handleScroll);
    
    // Initial check in case elements are already in viewport
    handleScroll();
});
</script>
@endpush
