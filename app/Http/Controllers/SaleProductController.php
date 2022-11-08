<?php

namespace App\Http\Controllers;

use App\Models\SaleProduct;
use Illuminate\Http\Request;

class SaleProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexshop()
    {
        return view('shop');
    }
}
