<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'user_id', 'customer_id', 'amount', 'due', 'invoice_url'
    ];

    function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
