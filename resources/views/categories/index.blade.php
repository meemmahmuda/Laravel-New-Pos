@extends('layouts.master')

@section('title', 'Category List')

@section('content')
    <div class="container">
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>
        <table class="table table-bordered mt-3">
            <thead> 
                <tr style="text-align: center;">
                    <th>SL No.</th>
                    <th style="width: 60%;">Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection