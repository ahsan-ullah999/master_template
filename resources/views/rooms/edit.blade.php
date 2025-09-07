@extends('layouts.app')
@section('title','Edit Room')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Room</h2>
    <form action="{{ route('rooms.update',$room->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('rooms.partials.form',['room'=>$room])
        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary mt-3">Back</a>
    </form>
</div>
@endsection
