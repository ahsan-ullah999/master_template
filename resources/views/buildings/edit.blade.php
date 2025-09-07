@extends('layouts.app')
@section('title','Edit Building')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Building</h2>
    <form action="{{ route('buildings.update',$building->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('buildings.partials.form',['building'=>$building])
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('buildings.index') }}" class="btn btn-secondary mt-3">Back</a>
    </form>
</div>
@endsection
