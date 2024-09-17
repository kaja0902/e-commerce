<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(){
        
        $cartitems = Cart::where('user_id',Auth::id())->get();
        return view('frontend.checkout', compact('cartitems'));

    }

    public function placeorder(Request $request){
        
        $order = new Order();
        $order->user_id = Auth::id();
        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->adress1 = $request->input('adress1');
        $order->adress2 = $request->input('adress2');
        $order->city = $request->input('city');
        $order->country = $request->input('country');
        $order->zipcode = $request->input('zipcode');
        $order->tracking_no = 'e-shop'.rand(1111,9999);
        $order->save();

        $totalPrice = 0;

        $cartitems = Cart::where('user_id',Auth::id())->get();
        foreach($cartitems as $item){
            
            OrderItem::create([
                'order_id' => $order->id,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->selling_price,
            ]);

            $prod = Product::where('id', $item->prod_id)->first();
            $prod->qty = $prod->qty - $item->prod_qty;
            $prod->update();

            $totalPrice += $item->prod_qty * $item->products->selling_price;
            //$total_price += $prod->products->selling_price * $prod->qty;
        }

        $deliveryPrice = env('DELIVERY_PRICE', 0);
        $totalPriceWithDelivery = $totalPrice + $deliveryPrice;

        $order->total_price = $totalPriceWithDelivery;
        $order->delivery_price = $deliveryPrice; 
        $order->save();

        if(Auth::user()->adress1 == NULL){

            $user = User::where('id', Auth::id())->first();
            $user->id = Auth::id();
            $user->name = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->phone = $request->input('phone');
            $user->adress1 = $request->input('adress1');
            $user->adress2 = $request->input('adress2');
            $user->city = $request->input('city');
            $user->country = $request->input('country');
            $user->zipcode = $request->input('zipcode');
            $user->update();
        }
        $cartitems = Cart::where('user_id',Auth::id())->get();
        Cart::destroy($cartitems);

        return redirect('/')->with('status', "Order placed Successfully");
    }

    public function razorpaycheck(Request $request){

        $cartitems= Cart::where('user_id', Auth::id())->get();
        $total_price = 0;

        foreach($cartitems as $item){
            $total_price += $item->products->selling_price* $item->prod_qty;
        }

        $firstname  = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $phone  = $request->input('phone');
        $adress1 = $request->input('adress1');
        $city  = $request->input('city');
        $country = $request->input('country');
        $zipcode = $request->input('zipcode');

        return response()->json([
            'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'phone' => $phone,
                'adress1' => $adress1,
                'city' => $city,
                'country' => $country,
                'zipcode' => $zipcode,
                'total_price' => $total_price
        ]);
    }
}
