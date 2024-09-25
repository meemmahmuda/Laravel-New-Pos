
@extends('layouts.master')

@section('title', 'Edit Category')

@section('content')
    <div class="container">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
            </div>
   
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
