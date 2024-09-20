<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\Wishlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated()
{
    // Migracija sesije u bazu nakon logovanja
    if (Session::has('cart')) {
        $cartItems = Session::get('cart');

        foreach ($cartItems as $item) {
            // Proveri da li proizvod već postoji u korisnikovoj korpi
            $existingCartItem = Cart::where('user_id', Auth::id())
                                    ->where('prod_id', $item['prod_id'])
                                    ->first();

            if (!$existingCartItem) {
                // Ako proizvod ne postoji, dodaj ga u bazu
                Cart::create([
                    'user_id' => Auth::id(),
                    'prod_id' => $item['prod_id'],
                    'prod_qty' => $item['qty'],
                ]);
            }
        }

        // Očisti korpu iz sesije nakon prebacivanja u bazu
        Session::forget('cart');
    }

    // Sada obavi redirekciju
    if (Auth::user()->role_as == '1') //1 = Admin Login
    {
        return redirect('/dashboard')->with('status','Welcome to your dashboard');
    }
    elseif (Auth::user()->role_as == '0') // Normal or Default User Login
    {
        return redirect('/')->with('status','Logged in successfully');
    }
}

    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
