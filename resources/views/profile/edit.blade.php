@extends('layouts.app')
@section('title', 'My Profile')
<x-navbar />
@section('content')
    
    <x-sidebar />

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

                {{-- Profile Information --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Profile Information') }}</h5>
                        <small class="text-muted">{{ __("Update your account's profile information and email address.") }}</small>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Update Password --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Update Password') }}</h5>
                        <small class="text-muted">{{ __('Ensure your account is using a strong password.') }}</small>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Delete Account --}}
                {{-- <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Delete Account') }}</h5>
                        <small class="text-muted">
                            {{ __('Once deleted, all data will be permanently removed. Download any data you want to keep.') }}
                        </small>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
@endsection
