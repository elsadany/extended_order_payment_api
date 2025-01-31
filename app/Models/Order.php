<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
