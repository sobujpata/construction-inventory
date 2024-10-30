<?php

namespace App\Http\Controllers;

use App\Models\Union;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BnLocationController extends Controller
{
    public function Division(){
        return Division::all();
    }
    public function District(){
        return District::all();
    }
    public function Upazila(){
        return Upazila::all();
    }
    public function Union(){
        return Union::all();
    }

}
