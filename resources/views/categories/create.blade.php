@extends('layouts.master')

@section('title', 'Create Category')

@section('content')
    <div class="container">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection