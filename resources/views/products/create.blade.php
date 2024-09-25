
@extends('layouts.master')
@section('title', 'Create Products')

@section('content')
    <div class="container">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div id="products-container">
                <div class="product-form-group">
                    <h4 style="text-align: center; font-weight: bold; color: blue;font-size: 20px">Product 1</h4>
                    <div class="form-group">
                        <label for="products[0][name]">Product Name</label>
                        <input type="text" name="products[0][name]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="products[0][code]">Product Code</label>
                        <input type="text" name="products[0][code]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="products[0][supplier_id]">Supplier</label>
                        <select name="products[0][supplier_id]" class="form-control" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="products[0][category_id]">Category</label>
                        <select name="products[0][category_id]" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="products[0][purchase_price]">Purchase Price</label>
                        <input type="number" name="products[0][purchase_price]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="products[0][selling_price]">Selling Price</label>
                        <input type="number" name="products[0][selling_price]" class="form-control" required>
                    </div>
                </div>
            </div><br>
            <button type="button" id="add-product" class="btn btn-secondary">
                <i class="fa fa-plus"></i> Add Another Product
            </button>
            <button type="submit" class="btn btn-primary">Save Products</button>
        </form>
    </div>

    <script>
        let productCount = 1;

        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products-container');
            const newProduct = document.createElement('div');
            newProduct.classList.add('product-form-group');
            newProduct.innerHTML = `
                <br><h4 style="text-align: center; font-weight: bold; color: blue;font-size: 20px">Product ${productCount + 1}</h4>
                <div class="form-group">
                    <label for="products[${productCount}][name]">Product Name</label>
                    <input type="text" name="products[${productCount}][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="products[${productCount}][code]">Product Code</label>
                    <input type="text" name="products[${productCount}][code]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="products[${productCount}][supplier_id]">Supplier</label>
                    <select name="products[${productCount}][supplier_id]" class="form-control" required>
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="products[${productCount}][category_id]">Category</label>
                    <select name="products[${productCount}][category_id]" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="products[${productCount}][purchase_price]">Purchase Price</label>
                    <input type="number" name="products[${productCount}][purchase_price]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="products[${productCount}][selling_price]">Selling Price</label>
                    <input type="number" name="products[${productCount}][selling_price]" class="form-control" required>
                </div><br>
                <button type="button" class="btn btn-danger remove-product">
                    <i class="fa fa-minus"></i> Remove Product
                </button>
            `;
            container.appendChild(newProduct);
            productCount++;
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-product')) {
                e.target.parentElement.remove();
            }
        });
    </script>
@endsection
