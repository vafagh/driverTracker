<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rideable;
use App\Ride;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    }
}
