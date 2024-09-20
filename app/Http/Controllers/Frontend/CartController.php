<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');

        $product = Product::find($product_id);

        if ($product) {
            if ($product->qty >= $product_qty) {
                if (Auth::check()) {
                    // Ako je korisnik prijavljen
                    if (Cart::where('prod_id', $product_id)->where('user_id', Auth::id())->exists()) {
                        return response()->json(['status' => $product->name . " is already added to cart"]);
                    } else {
                        $cartItem = new Cart();
                        $cartItem->prod_id = $product_id;
                        $cartItem->user_id = Auth::id();
                        $cartItem->prod_qty = $product_qty;
                        $cartItem->save();
                        return response()->json(['status' => $product->name . " added to cart"]);
                    }
                } else {
                    // Ako korisnik nije prijavljen
                    $cart = Session::get('cart', []);
                    $cartItem = [
                        'prod_id' => $product_id,
                        'qty' => $product_qty,
                        'name' => $product->name,
                        'image' => $product->image,
                        'selling_price' => $product->selling_price,
                    ];
                    $cart[$product_id] = $cartItem;
                    Session::put('cart', $cart);
                    return response()->json(['status' => $product->name . " added to cart"]);
                }
            } else {
                return response()->json(['status' => $product->name . " is out of stock"]);
            }
        } else {
            return response()->json(['status' => "Product not found"]);
        }
    }

    public function viewCart()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
            return view('frontend.cart', compact('cartItems'));
        } else {
            $cart = Session::get('cart', []);
            return view('frontend.cart', ['cartItems' => collect($cart)]);
        }
    }

    public function updateCart(Request $request)
    {
        $prod_id = $request->input('prod_id');
        $product_qty = $request->input('prod_qty');

        if (Auth::check()) {
            if (Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->exists()) {
                $cart = Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->first();
                $cart->prod_qty = $product_qty;
                $cart->update();
                return response()->json(['status' => "Quantity updated"]);
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$prod_id])) {
                $cart[$prod_id]['qty'] = $product_qty;
                Session::put('cart', $cart);
                return response()->json(['status' => "Quantity updated"]);
            }
        }

        return response()->json(['status' => "Product not found in cart"]);
    }

    public function deleteProduct(Request $request)
    {
        $prod_id = $request->input('prod_id');

        if (Auth::check()) {
            if (Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->exists()) {
                $cartItem = Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->first();
                $cartItem->delete();
                return response()->json(['status' => "Product removed from cart"]);
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$prod_id])) {
                unset($cart[$prod_id]);
                Session::put('cart', $cart);
                return response()->json(['status' => "Product removed from cart"]);
            }
        }

        return response()->json(['status' => "Product not found in cart"]);
    }

    public function cartCount()
    {
        if (Auth::check()) {
            $cartcount = Cart::where('user_id', Auth::id())->count();
        } else {
            $cart = Session::get('cart', []);
            $cartcount = count($cart);
        }

        return response()->json(['count' => $cartcount]);
    }
}
