@extends('layouts.app')
@section('title','Edit Branch')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Branch</h2>
    <form action="{{ route('branches.update',$branch->id) }}" method="POST">
        @csrf @method('PUT')
        @include('branches.partials.form',['branch'=>$branch])
        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
