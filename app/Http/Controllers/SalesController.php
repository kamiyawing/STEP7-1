<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function getList() {
        $sales = DB::table('sales');
        return $sales;
    }
}
