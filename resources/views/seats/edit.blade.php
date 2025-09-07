@extends('layouts.app')
@section('title','Edit Seat')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Seat</h2>
    <form action="{{ route('seats.update',$seat->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('seats.partials.form',['seat'=>$seat])
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('seats.index') }}" class="btn btn-secondary mt-3">Back</a>
    </form>
</div>
@endsection
