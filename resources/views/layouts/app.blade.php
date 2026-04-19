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

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- ✅ Laravel Compiled CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/products.css') }}">
  <link rel="stylesheet" href="{{ asset('css/about.css') }}">

  <!-- ✅ Critical CSS Fallback -->
  <style>
    :root {
      --color-bg: #FFF7F2;
      --color-surface: #FFFFFF;
      --color-primary: #E83F6F;
      --color-primary-600: #C22E59;
      --color-secondary: #FFB703;
      --color-accent: #2A9D8F;
      --color-neutral-900: #2E2A27;
      --color-neutral-700: #4B3A36;
      --color-neutral-500: #8D7B73;
      --color-border: #E6DAD2;
      --radius-sm: 8px;
      --radius-lg: 16px;
    }

    body {
      background: var(--color-bg, #FFF7F2);
      color: var(--color-neutral-900, #2E2A27);
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Inter, Ubuntu, 'Helvetica Neue', Arial, sans-serif;
    }
  </style>

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