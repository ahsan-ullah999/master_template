@extends('layouts.app')
@section('title','Edit Flat')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Flat</h2>
    <form action="{{ route('flats.update',$flat->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('flats.partials.form',['flat'=>$flat])
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('flats.index') }}" class="btn btn-secondary mt-3">Back</a>
    </form>
</div>
@endsection
