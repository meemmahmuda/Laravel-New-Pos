@extends('layouts.master')

@section('content')

        <!-- Main Content -->
<div>
    <div class="container">
        <div class="row" style="margin-top: 60px;">
            
            <!-- Categories Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="small-box" style="background-color: #007bff; border-radius: 5px; color: #fff; position: relative;">
                    <div class="inner" style="padding: 15px;">
                        <h3 style="font-size: 28px; font-weight: bold;">{{ $categories }}</h3>
                        <p style="font-size: 16px;">Total Categories</p>
                    </div>
                    <div class="icon" style="position: absolute; top: -55px; right: -5px;">
                        <i class="fa-solid fa-layer-group" 
                        style="font-size: 50px; color: #007bff; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        </i>
                    </div>
                    <a href="{{ route('categories.index') }}" class="small-box-footer" 
                    style="display: block; padding: 10px; color: #fff; background-color: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(0, 0, 0, 0.1); text-align: center; text-decoration: none;">
                        View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Suppliers Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="small-box" style="background-color: #f39c12; border-radius: 5px; color: #fff; position: relative;">
                    <div class="inner" style="padding: 15px;">
                        <h3 style="font-size: 28px; font-weight: bold;">{{ $suppliers }}</h3>
                        <p style="font-size: 16px;">Total Suppliers</p>
                    </div>
                    <div class="icon" style="position: absolute; top: -55px; right: -5px;">
                        <i class="fa fa-id-card" 
                        style="font-size: 50px; color: #f39c12; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        </i>
                    </div>
                    <a href="{{ route('suppliers.index') }}" class="small-box-footer" 
                    style="display: block; padding: 10px; color: #fff; background-color: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(0, 0, 0, 0.1); text-align: center; text-decoration: none;">
                        View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Products Box -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="small-box" style="background-color: #28a745; border-radius: 5px; color: #fff; position: relative;">
                    <div class="inner" style="padding: 15px;">
                        <h3 style="font-size: 28px; font-weight: bold;">{{ $products }}</h3>
                        <p style="font-size: 16px;">Total Products</p>
                    </div>
                    <div class="icon" style="position: absolute; top: -55px; right: -5px;">
                        <i class="fa fa-cube" 
                        style="font-size: 50px; color: #28a745; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        </i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer" 
                    style="display: block; padding: 10px; color: #fff; background-color: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(0, 0, 0, 0.1); text-align: center; text-decoration: none;">
                        View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
                
            <!-- Orders Box -->
            <div class="col-lg-4 col-md-6 mb-4" style="margin-top: 60px;">
                <div class="small-box" style="background-color: #17a2b8; border-radius: 5px; color: #fff; position: relative;">
                    <div class="inner" style="padding: 15px;">
                        <h3 style="font-size: 28px; font-weight: bold;">{{ $orders }}</h3>
                        <p style="font-size: 16px;">Total Orders</p>
                    </div>
                    <div class="icon" style="position: absolute; top: -55px; right: -5px;">
                        <i class="fa fa-shopping-cart" 
                        style="font-size: 50px; color: #17a2b8; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        </i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer" 
                    style="display: block; padding: 10px; color: #fff; background-color: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(0, 0, 0, 0.1); text-align: center; text-decoration: none;">
                        View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


            <!-- Purchase Box -->
            <div class="col-lg-4 col-md-6 mb-4" style="margin-top: 60px;">
                <div class="small-box" style="background-color: #2ed573; border-radius: 5px; color: #fff; position: relative;">
                    <div class="inner" style="padding: 15px;">
                        <h3 style="font-size: 28px; font-weight: bold;">{{ $purchases }}</h3>
                        <p style="font-size: 16px;">Total Purchases</p>
                    </div>
                    <div class="icon" style="position: absolute; top: -55px; right: -5px;">
                    <i class="fa-solid fa-bag-shopping"
                        style="font-size: 50px; color: #2ed573; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        </i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer" 
                    style="display: block; padding: 10px; color: #fff; background-color: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(0, 0, 0, 0.1); text-align: center; text-decoration: none;">
                        View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


            <!-- Sales Box -->
            <div class="col-lg-4 col-md-6 mb-4" style="margin-top: 60px;">
                <div class="small-box" style="background-color: #e83e8c; border-radius: 5px; color: #fff; position: relative;">
                    <div class="inner" style="padding: 15px;">
                        <h3 style="font-size: 28px; font-weight: bold;">{{ $sales }}</h3>
                        <p style="font-size: 16px;">Total Sales</p>
                    </div>
                    <div class="icon" style="position: absolute; top: -55px; right: -5px;">
                        <i class="fa fa-dollar-sign" 
                        style="font-size: 50px; color: #e83e8c; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        </i>
                    </div>
                    <a href="{{ route('sales.index') }}" class="small-box-footer" 
                    style="display: block; padding: 10px; color: #fff; background-color: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(0, 0, 0, 0.1); text-align: center; text-decoration: none;">
                        View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Sales Return Box -->
            <div class="col-lg-4 col-md-6 mb-4" style="margin-top: 60px;">
                <div class="small-box" style="background-color: #dc3545; border-radius: 5px; color: #fff; position: relative;">
                    <div class="inner" style="padding: 15px;">
                        <h3 style="font-size: 28px; font-weight: bold;">{{ $salesreturn }}</h3>
                        <p style="font-size: 16px;">Total Sales Returns</p>
                    </div>
                    <div class="icon" style="position: absolute; top: -55px; right: -5px;">
                        <i class="fa fa-undo" 
                        style="font-size: 50px; color: #dc3545; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);">
                        </i>
                    </div>
                    <a href="{{ route('sales_returns.index') }}" class="small-box-footer" 
                    style="display: block; padding: 10px; color: #fff; background-color: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(0, 0, 0, 0.1); text-align: center; text-decoration: none;">
                        View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection