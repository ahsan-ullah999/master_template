@extends('layouts.app')
@section('title','Edit Member')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Member</h2>
    <form action="{{ route('members.update',$member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
       <div class="card shadow-sm border-0 rounded-3 mb-3">
                <div class="card-body">
                    {{-- Placement & Admission Fields (your partial content) --}}
                    @include('members.partials.form')
                </div>

                {{-- Buttons aligned properly --}}
                <div class="card-footer d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Update
                    </button>
                    <a href="{{ route('members.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Cancel
                    </a>
                </div>
            </div>
    </form>
</div>
@endsection
