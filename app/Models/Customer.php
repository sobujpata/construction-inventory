<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name','email','mobile','division_id', 'district_id', 'upazila_id', 'union_id', 'postal_code', 'village', 'present_address', 'image'];
}
