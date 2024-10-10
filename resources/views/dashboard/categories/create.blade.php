@extends('layouts.dashboard')

@section('title', 'Create A Category')

@section('breadcrump')
    @parent
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.categories._form')
    </form>
@endsection
