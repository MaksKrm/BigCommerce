<?php

namespace App\Http\Controllers\BigCommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntegrationsController extends Controller
{
    public function index(Request $request)
    {
        return view('bigCommerce.index');
    }
}
