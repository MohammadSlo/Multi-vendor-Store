@extends('layouts.dashboard')

@section('title', 'Trashed Categories')

@section('breadcrump')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
    </div>

    <x-alert type="success" />
    <x-alert type="warning" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justufy-content-between mb-4">
        <x-form.input name="name" placeholder="name" class="mx-2" value="{{ request('name') }}" />
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status' == 'active'))>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button class="btn btn-dark">Filter</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>#ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Deleted_at</th>
                <th colspan="2"></th>

            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->deleted_at }}</td>
                    <td>
                        <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="post">
                            @csrf
                            {{-- <input type="hidden" name="_method" value="delete"> --}}
                            @method('put')
                            <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                        </form>
                    </td>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete Forever</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="" class="text-center">No categories found!</td>
                </tr>
        </tbody>
        @endforelse
    </table>
    {{ $categories->withQueryString()->links() }}
@endsection
