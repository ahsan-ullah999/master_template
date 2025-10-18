@extends('layouts.app')
@section('title','Company Info')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow rounded">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Group Details</h4>
                    
                </div>
                <div class="card-body" style="background-color: #f9f9f9;">
                    <div class="row">
                        {{-- Group Name --}}
                        <div class="col-md-6 mb-3">
                            <strong>Name:</strong>
                            <p style="font-size: 1.1rem;">{{ $group->name }}</p>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong>
                            <p style="font-size: 1.1rem;">{{ $group->email }}</p>
                        </div>

                        {{-- Contact Number --}}
                        <div class="col-md-6 mb-3">
                            <strong>Contact Number:</strong>
                            <p style="font-size: 1.1rem;">{{ $group->contact_number }}</p>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6 mb-3">
                            <strong>Address:</strong>
                            <p style="font-size: 1.1rem;">{{ $group->address }}</p>
                        </div>

                        {{-- Logo --}}
                        <div class="col-md-6 text-center">
                            <lavel class="form-label fw-semibold text-dark d-block mb-2">Logo :</lavel>
                            
                            <div class="preview-box mx-auto p-3 rounded shadow-sm" 
                                style="background:#f5f5f5;border:2px dashed #ccc;width:180px;height:180px;display:flex;align-items:center;justify-content:center;">
                            @if($group->logo)
                                <img src="{{ asset('storage/'.$group->logo) }}" alt="Group Logo" class="img-fluid rounded shadow" style="max-height: 150px;">
                            @else
                                <p>No logo uploaded</p>
                            @endif
                            </div>
                           
                        </div>
                        {{-- Login Background --}}
                        <div class="col-md-6 text-center">
                            <lavel class="form-label fw-semibold text-dark d-block mb-2">Login Background:</lavel>
                            
                            <div class="preview-box mx-auto p-3 rounded shadow-sm" 
                                style="background:#f5f5f5;border:2px dashed #ccc;width:180px;height:180px;display:flex;align-items:center;justify-content:center;">
                                @if($group->login_background)
                                    <img src="{{ asset('storage/'.$group->login_background) }}" alt="Login Background" class="img-fluid rounded shadow" style="max-height: 150px;">
                                @else
                                    <p>No background uploaded</p>
                                @endif
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-sm btn-primary">Edit Group</a>
                    <a href="{{ route('groups.index') }}" class="btn btn-sm bg-secondary text-light">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
