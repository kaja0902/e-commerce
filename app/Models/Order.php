<?php

namespace App\Models;

use App\Models\OrderItem;
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
}
