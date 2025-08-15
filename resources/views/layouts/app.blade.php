<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Wish Bakery - Freshly baked treats, cakes, and pastries made with love.">

  <!-- ✅ Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- ✅ Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <title>@yield('title', 'Wish Bakery')</title>

  <!-- ✅ Laravel Compiled CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/products.css') }}">
  <link rel="stylesheet" href="{{ asset('css/about.css') }}">
  
  @stack('styles')
</head>

<body>
  @include('partials.header')

  <main>
    <div class="container py-4">
      @yield('content')
    </div>
  </main>

  @include('partials.footer')

  <!-- ✅ jQuery (load first since it's a dependency) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- ✅ Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- ✅ Laravel JS -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  @stack('scripts')
</body>
</html>
