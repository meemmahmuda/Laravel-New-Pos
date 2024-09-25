@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Orders</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Create Order</a>
    
</div>
@endsection
