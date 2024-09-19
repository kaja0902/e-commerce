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
        // Porudžbine po mesecima
        $ordersPerMonth = DB::table('orders')
            ->select(DB::raw('COUNT(*) as total_orders'), DB::raw('MONTH(created_at) as month'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();
    
        $months = $ordersPerMonth->pluck('month')->map(function($month) {
            return date('F', mktime(0, 0, 0, $month, 10));
        })->toArray();
    
        $orderCounts = $ordersPerMonth->pluck('total_orders')->toArray();
    
        // Porudžbine po nedeljama (poslednjih 10 nedelja)
        $ordersPerWeek = DB::table('orders')
            ->select(DB::raw('COUNT(*) as total_orders'), DB::raw('WEEK(created_at) as week'))
            ->where('created_at', '>=', now()->subWeeks(10))
            ->groupBy('week')
            ->orderBy('week', 'ASC')
            ->get();
    
        $weeks = $ordersPerWeek->pluck('week')->toArray();
        $orderCountsPerWeek = $ordersPerWeek->pluck('total_orders')->toArray();
    
        return view('admin.index', compact('months', 'orderCounts', 'weeks', 'orderCountsPerWeek'));
    }

}
