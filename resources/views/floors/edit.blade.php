@extends('layouts.app')
@section('title','Edit Floor')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Floor</h2>
    <form action="{{ route('floors.update',$floor->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('floors.partials.form',['floor'=>$floor])
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('floors.index') }}" class="btn btn-secondary mt-3">Back</a>
    </form>
</div>
@endsection
