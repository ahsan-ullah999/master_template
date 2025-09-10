@extends('layouts.app')
@section('title','Edit Member')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Member</h2>
    <form action="{{ route('members.update',$member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('members.partials.form')
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
