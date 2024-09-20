@extends('layouts.front')

@section('title')
    My Cart
@endsection

@section('content')
<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('/') }}">
                Home
            </a> /
            <a href="{{ url('wishlist') }}">
                Wishlist
            </a> 
        </h6>
    </div>
</div>

<div class="container my-5">
    <div class="card shadow">
        <div class="card-body">          
            @if($wishlist->count() > 0)
                @foreach ($wishlist as $item)
                    <div class="row product_data">
                        <div class="col-md-2">
                            @if(isset($item->image)) 
                                <!-- Ako je proizvod objekat i ima sliku -->
                                <img src="{{ asset('assets/uploads/products/'.$item->image) }}" height="70px" width="70px" alt="Image here">
                            @else
                                <!-- Default slika ako ne postoji -->
                                <img src="{{ asset('assets/uploads/products/default.jpg') }}" height="70px" width="70px" alt="Image here">
                            @endif
                        </div>

                        <div class="col-md-2 my-auto">
                            @if(isset($item->name))
                                <h6>{{ $item->name }}</h6>
                            @else
                                <h6>Unknown Product</h6>
                            @endif
                        </div>

                        <div class="col-md-2 my-auto">
                            @if(isset($item->selling_price))
                                <h6>  {{ $item->selling_price }} rsd</h6>
                            @else
                                <h6>Price not available</h6>
                            @endif
                        </div>                                    
                        <div class="col-md-2 my-auto">
                            <input type="hidden" name="prod_id" class="prod_id" value="{{ $item->id }}">
                            <input type="hidden" name="quantity" class="form-control qty-input text-center" value="1">
                        </div>

                        <div class="col-md-2 my-auto">
                            <button class="btn btn-success addToCartBtn"><i class="fa fa-shopping-cart">Add to Cart</i></button>
                        </div>

                        <div class="col-md-2 my-auto">
                            <button class="btn btn-danger remove-wishlist-item"><i class="fa fa-trash">Remove</i></button>
                        </div>
                    </div>
                @endforeach
            @else
                <h4>There are no products in your Wishlist</h4>
            @endif
        </div>
    </div>
</div>
@endsection