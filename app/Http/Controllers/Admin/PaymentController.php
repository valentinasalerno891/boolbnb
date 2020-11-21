<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class PaymentController extends Controller
{
    public function checkout() 
     {
          return view('admin.checkout');
     }
}
