<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class AdminCustomerController extends Controller
{
    public function index()
    {
        // Ambil semua data pelanggan dari yang terbaru
        $customers = Customer::latest()->get();
        return view('admin.pelanggan', compact('customers'));
    }
}