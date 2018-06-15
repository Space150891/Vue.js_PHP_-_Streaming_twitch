<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoPageController extends Controller
{
    public function __invoke() {
        return view('layouts.video');
    }
}
