<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function index()
{
    if (Auth::check()) {
        // Ako je korisnik prijavljen, uzmi wishlist-u iz baze
        if (Session::has('wishlist')) {
            $wishlistSession = Session::get('wishlist');

            foreach ($wishlistSession as $sessionItem) {
                // Provera da li proizvod već postoji u bazi za korisnika
                $wishlistItem = Wishlist::where('user_id', Auth::id())
                                        ->where('prod_id', $sessionItem->id)
                                        ->first();
                if (!$wishlistItem) {
                    // Ako proizvod ne postoji, dodaj ga u bazu
                    Wishlist::create([
                        'user_id' => Auth::id(),
                        'prod_id' => $sessionItem->id,
                    ]);
                }
            }
    
            // Obriši wishlist iz sesije nakon prebacivanja u bazu
            Session::forget('wishlist');
        }

        $wishlist = collect();
        $userWishlistItems = Wishlist::with('products')->where('user_id', Auth::id())->get();

        foreach ($userWishlistItems as $userWishlistItem){
            $wishlist->push($userWishlistItem->products);
        }
    } else {
        // Ako korisnik nije prijavljen, uzmi wishlist-u iz sesije
        $wishlistSession = Session::get('wishlist', []);

        // Ručno pretvaranje proizvoda iz sesije u odgovarajući oblik
        $wishlist = collect();
        foreach ($wishlistSession as $product){
            $wishlist->push($product);
        }
    }

    return view('frontend.wishlist', compact('wishlist'));
}

    public function add(Request $request) {
    $prod_id = $request->input('product_id');
    $product = Product::find($prod_id);

    if ($product) {
        if (Auth::check()) {
            // Ako je korisnik prijavljen, sačuvaj wishlistu u bazi
            $wish = new Wishlist();
            $wish->prod_id = $prod_id;
            $wish->user_id = Auth::id();
            $wish->save();
            return response()->json(['status' => "Product Added to Wishlist"]);
        } else {
            // Ako korisnik nije prijavljen, sačuvaj wishlistu u sesiji
            $wishlist = Session::get('wishlist', []);

            $wishlistItem = [
                'prod_id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'selling_price' => $product->selling_price,
            ];

            $wishlist[$prod_id] = $product;
            Session::put('wishlist', $wishlist);

            return response()->json(['status' => "Product Added to Wishlist"]);
        }
    } else {
        return response()->json(['status' => "Product does not exist"]);
    }
}

    public function deleteitem(Request $request){
        $prod_id = $request->input('prod_id');

        if (Auth::check()) {
            // Ako je korisnik prijavljen, ukloni proizvod iz baze
            if (Wishlist::where('prod_id', $prod_id)->where('user_id', Auth::id())->exists()) {
                $wish = Wishlist::where('prod_id', $prod_id)->where('user_id', Auth::id())->first();
                $wish->delete();
                return response()->json(['status' => "Item Removed from Wishlist"]);
            }
        } else {
            // Ako korisnik nije prijavljen, ukloni proizvod iz sesije
            $wishlist = Session::get('wishlist', []);
            if (isset($wishlist[$prod_id])) {
                unset($wishlist[$prod_id]); // Ukloni proizvod iz wishlist
                Session::put('wishlist', $wishlist);
                return response()->json(['status' => "Item Removed from Wishlist"]);
            }
        }

        return response()->json(['status' => "Item not found in Wishlist"]);
    }

    public function wishlistcount()
{
    if (Auth::check()) {
        // Ako je korisnik prijavljen, brojimo wishlist stavke iz baze
        $wishcount = Wishlist::where('user_id', Auth::id())->count();
    } else {
        // Ako korisnik nije prijavljen, brojimo wishlist stavke iz sesije
        $wishlist = Session::get('wishlist', []);
        $wishcount = count($wishlist);
    }

    return response()->json(['count' => $wishcount]);
}



}
