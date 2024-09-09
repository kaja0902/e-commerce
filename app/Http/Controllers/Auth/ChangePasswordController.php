<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $auth = Auth::user();

        if (!Hash::check($request->current_password, $auth->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user = User::find($auth->id);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('change-password')->with('success', 'Password changed successfully');
    }
}
