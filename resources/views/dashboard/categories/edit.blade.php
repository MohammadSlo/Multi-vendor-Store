@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('breadcrump')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.categories._form', [
            'button_label' => 'Update',
        ])

    </form>

@endsection
