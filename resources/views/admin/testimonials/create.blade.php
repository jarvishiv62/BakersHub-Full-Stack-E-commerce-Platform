@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Add New Testimonial</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.testimonials.store') }}" method="POST">
                @include('admin.testimonials._form')
            </form>
        </div>
    </div>
</div>
@endsection