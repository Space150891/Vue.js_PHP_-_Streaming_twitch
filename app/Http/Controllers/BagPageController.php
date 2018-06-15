<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BagPageController extends Controller
{
    public function __invoke() {
        return view('layouts.bag');
    }
}
