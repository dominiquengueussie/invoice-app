<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getCustomer()
    {
        $customer = Customer::orderBy('id', 'DESC')->get();

        return response()->json([
            'customer' => $customer
        ], 200);
    }
}
