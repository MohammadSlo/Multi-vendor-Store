@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('breadcrump')
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')

    <x-alert type="success" />


    <form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="first_name" label="First Name" :value="$user->profile->first_name" />
            </div>
            <div class="col-md-6">
                <x-form.input name="last_name" label="Last Name" :value="$user->profile->last_name" />
            </div>
        </div>


        <div class="form-row">
            <div class="col-md-6">
                <x-form.input type="date" name="birthday" label="Birthday" :value="$user->profile->birthday" />
            </div>
            <div class="col-md-6">
                <x-form.radio name="gender" label="Gender" :options="['male' => 'Male', 'female' => 'Female']" :value="$user->profile->gender" :checked="$user->profile->gender" />
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-4">
                <x-form.input name="street_address" label="Street Adress" :value="$user->profile->street_address" />
            </div>
            <div class="col-md-4">
                <x-form.input name="city" label="City" :value="$user->profile->city" />
            </div>
            <div class="col-md-4">
                <x-form.input name="state" label="state" :value="$user->profile->state" />
            </div>
        </div>


        <div class="form-row">
            <div class="col-md-4">
                <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postale_code" />
            </div>
            <div class="col-md-4">
                <x-form.select name="country" label="Country" :options="$countries" :selected="$user->profile->country" />
            </div>
            <div class="col-md-4">
                <x-form.select name="locale" label="Local" :options="$locales" :selected="$user->profile->locale" />
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>

    </form>

@endsection
