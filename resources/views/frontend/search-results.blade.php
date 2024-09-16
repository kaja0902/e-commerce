@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Search Results for "{{ $query }}"</h2>

    @if($products->isEmpty())
        <p>No products found.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('assets/uploads/products/'.$product->image) }}" alt="Product image" width="304px" />
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <a href="{{ route('productview', ['cate_slug' => $product->category->slug, 'prod_slug' => $product->slug]) }}" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
