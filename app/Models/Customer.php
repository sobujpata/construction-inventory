<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name','email','mobile','division_id', 'district_id', 'upazila_id', 'union_id', 'postal_code', 'village', 'present_address', 'image'];


    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }
    public function union()
    {
        return $this->belongsTo(Union::class);
    }
}
