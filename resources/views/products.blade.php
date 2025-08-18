@extends('layouts.app')

@section('title', 'Our Products | ' . config('app.name'))

@section('content')

   <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carousel1" data-bs-slide-to="0" class="active" aria-current="true"></button>
    <button type="button" data-bs-target="#carousel1" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#carousel1" data-bs-slide-to="2"></button>
  </div>

  <!-- Slides -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <a href="{{ route('products') }}">
        <img src="{{ asset('images/home/hero1.jpg') }}" class="d-block w-100" alt="Vanilla Cake">
      </a>
    </div>
    <div class="carousel-item">
      <a href="{{ route('products') }}">
        <img src="{{ asset('images/home/hero2.jpg') }}" class="d-block w-100" alt="Chocolate Cake">
      </a>
    </div>
    <div class="carousel-item">
      <a href="{{ route('products') }}">
        <img src="{{ asset('images/home/hero3.jpg') }}" class="d-block w-100" alt="Strawberry Cake">
      </a>
    </div>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Products Section -->
<section class="products-section pt-5">
    <div class="container products-container text-center">
        <div class="section-title">
            <h1>Our Fresh Bakes</h1>
            <p>Handcrafted with love and the finest ingredients, each bite is a celebration of flavor and tradition.</p>
        </div>

        <!-- Product Filters -->
        <form action="{{ route('products') }}" method="GET">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ $selectedCategory === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Sort By</option>
                        <option value="price_asc" {{ $selectedSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ $selectedSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search products..." 
                               value="{{ $searchQuery ?? '' }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                        @if($searchQuery || $selectedCategory || $selectedSort)
                            <a href="{{ route('products') }}" class="btn btn-outline-danger ms-2">
                                <i class="bi bi-x-lg"></i> Clear
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if(count($products) > 0)
            <!-- Products Grid -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($products as $product)
                <div class="col">
                    <div class="card h-100 product-card shadow-sm">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $product['image']) }}" class="card-img-top" alt="{{ $product['name'] }}" style="height: 200px; object-fit: cover;">
                            <span class="position-absolute top-0 end-0 bg-danger text-white small px-2 py-1 m-2 rounded">
                                {{ $product['category'] }}
                            </span>
                            @if(isset($product['rating']))
                            <div class="position-absolute bottom-0 start-0 m-2">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> {{ number_format($product['rating'], 1) }}
                                    <small class="text-muted">({{ $product['reviews'] ?? 0 }} reviews)</small>
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text text-muted mb-3">{{ $product['description'] ?? 'Delicious ' . strtolower($product['category']) . ' made with premium ingredients and baked fresh daily.' }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-primary">Rs {{ number_format($product['price'], 2) }}</span>
                                <button class="btn btn-primary add-to-cart" data-product-id="{{ $product['id'] }}">
                                    <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Product pagination" class="pagination-wrapper">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        @else
            <div class="alert alert-info mt-4">
                <h4 class="alert-heading">No products found!</h4>
                <p>We couldn't find any products matching your search criteria. Please try different filters.</p>
                <a href="{{ route('products') }}" class="btn btn-primary mt-2">View All Products</a>
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-truck fs-1 text-primary"></i>
                    </div>
                    <h3>Free Delivery</h3>
                    <p class="text-muted">On all orders above Rs. 1000</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-arrow-counterclockwise fs-1 text-primary"></i>
                    </div>
                    <h3>Easy Returns</h3>
                    <p class="text-muted">7-day return policy</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-shield-check fs-1 text-primary"></i>
                    </div>
                    <h3>Secure Payment</h3>
                    <p class="text-muted">100% secure payment</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            // Add your cart logic here
            console.log('Added to cart:', productId);
            
            // Show success message
            const toast = new bootstrap.Toast(document.getElementById('addedToCartToast'));
            toast.show();
        });
    });
</script>
@endpush

<!-- Success Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="addedToCartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <i class="bi bi-check-circle-fill text-success me-2"></i>
            Item added to cart successfully!
        </div>
    </div>
</div>

@endsection