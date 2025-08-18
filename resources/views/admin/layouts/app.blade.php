@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">@yield('title', 'Dashboard')</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                @yield('actions')
            </div>
        </div>

        @yield('main-content')
    </div>
@endsection
