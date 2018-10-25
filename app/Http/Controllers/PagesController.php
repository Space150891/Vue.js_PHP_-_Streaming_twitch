<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function main()
    {
        return view('pages.main');
    }

    public function games()
    {
        return view('pages.games');
    }

    public function game($gameName)
    {
        return view('pages.game', ['gameName'   => $gameName]);
    }

    public function watchStream($streamName)
    {
        return view('pages.watchStream', ['streamName'   => $streamName]);
    }

    public function allPrizes()
    {
        return view('pages.allPrizes');
    }

    public function shop($caseId = 0)
    {
        return view('pages.shop', ['caseId'    =>  $caseId]);
    }

    public function cabinet()
    {
        return view('pages.cabinet');
    }

    public function myInventory()
    {
        return view('pages.myInventory');
    }

    public function upgrade()
    {
        return view('pages.upgrade');
    }

    public function profile($name)
    {
        return view('pages.profile', ['viewerName'   => $name]);
    }

}
