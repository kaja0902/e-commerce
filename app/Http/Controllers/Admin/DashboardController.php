<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function users(){
        
        $users = User::all();
        return view('admin.users.index', compact('users'));

    }

    public function viewuser($id){
        $user = User::find($id); // Pronalaženje korisnika prema ID-u
        
        if ($user) {
            return view('admin.users.view', compact('user')); // Prosleđivanje promenljive 'user'
        } else {
            return redirect('/')->with('status', "User not found");
        }
    }
}
