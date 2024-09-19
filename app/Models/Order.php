<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'fname',
        'lname',
        'email',
        'phone',
        'adress1',
        'adress2',
        'city',
        'country',
        'zipcode',
        'total_price',
        'status',
        'message',
        'tracking_no',
    ];

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    

    public static function getOrderCountByMonth()
    {
        return DB::table('orders')
            ->select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->pluck('count', 'month')->all();
    }

    public static function getOrderCountByWeek()
{
    return DB::table('orders')
        ->select(DB::raw('COUNT(*) as total_orders'), DB::raw('WEEK(created_at) as week'))
        ->where('created_at', '>=', now()->subWeeks(10)) // Prikazujemo poslednjih 10 nedelja
        ->groupBy('week')
        ->orderBy('week', 'ASC')
        ->get();
}

}
