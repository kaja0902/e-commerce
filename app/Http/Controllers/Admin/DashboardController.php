<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function getOrdersPerMonth() {
        $ordersPerMonth = DB::table('orders')
            ->select(DB::raw('COUNT(*) as total_orders'), DB::raw('MONTH(created_at) as month'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Pretvaranje u nizove koji će se koristiti u Highcharts
        $months = $ordersPerMonth->pluck('month')->map(function($month) {
            return date('F', mktime(0, 0, 0, $month, 10)); // Pretvaranje broja meseca u naziv meseca
        })->toArray();

        $orderCounts = $ordersPerMonth->pluck('total_orders')->toArray();

        return view('admin.index', compact('months', 'orderCounts'));
    }

}
