@extends('layouts.front')

@section('title')
    Checkout
@endsection

@section('content')
    <div class="container mt-3">
        <form action="{{ url('place-order') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h6>Basic Details</h6>
                            <hr>
                            <div class="row checkout-form">
                                <div class="col-md-6">
                                    <label for="">First Name</label>
                                    <input type="text" class="form-control firstname" value="{{ Auth::user()->name }}" name="fname" placeholder="Enter First Name">
                                    <span id="fname_error" class="text-danger" ></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control lastname" value="{{ Auth::user()->lname }}" name="lname" placeholder="Enter Last Name">
                                    <span id="lname_error" class="text-danger" ></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control email" value="{{ Auth::user()->email }}" name="email" placeholder="Enter Email">
                                    <span id="email_error" class="text-danger" ></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-control phone" value="{{ Auth::user()->phone }}" name="phone" placeholder="Enter Phone Number">
                                    <span id="phone_error" class="text-danger" ></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Adress 1</label>
                                    <input type="text" class="form-control adress1" value="{{ Auth::user()->adress1 }}" name="adress1" placeholder="Enter Adress 1">
                                    <span id="adress1_error" class="text-danger" ></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Adress 2</label>
                                    <input type="text" class="form-control adress2" value="{{ Auth::user()->adress2 }}" name="adress2" placeholder="Enter Adress 2">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Enter City</label>
                                    <input type="text" class="form-control city" value="{{ Auth::user()->city }}" name="city" placeholder="Enter City">
                                    <span id="city_error" class="text-danger" ></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Enter Country</label>
                                    <input type="text" class="form-control country" value="{{ Auth::user()->country }}" name="country" placeholder="Enter Country">
                                    <span id="country_error" class="text-danger" ></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Enter Zip Code</label>
                                    <input type="text" class="form-control zipcode" value="{{ Auth::user()->zipcode }}" name="zipcode" placeholder="Enter Zip Code">
                                    <span id="zipcode_error" class="text-danger" ></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h6>Order Details</h6>
                            <hr>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total Price</th> <!-- Dodaj novu kolonu -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartitems as $item)
                                    <tr>
                                        <td>{{ $item->products->name }}</td>
                                        <td>{{ $item->prod_qty }}</td>
                                        <td>{{ $item->products->selling_price }}</td>
                                        <td>{{ $item->prod_qty * $item->products->selling_price }}</td> <!-- Ukupna cena za stavku -->
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table> 
                            <hr>
                            <h6>Delivery Price: {{ env('DELIVERY_PRICE', 0) }} RSD</h6>

                            @php
                                $totalPrice = 0;
                                foreach ($cartitems as $item) {
                                    $totalPrice += $item->prod_qty * $item->products->selling_price;
                                }
                                $totalPriceWithDelivery = $totalPrice + env('DELIVERY_PRICE', 0);
                            @endphp

                            <h6>Total Price (with Delivery): {{ $totalPriceWithDelivery }} RSD</h6>
                            <button type="submit" class="btn btn-success w-100">Place Order | COD</button>
                            <button type="button" class="btn btn-primary w-100 mt-3 razorpay_btn">Pay with Razorpay</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js">
@endsection