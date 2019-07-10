<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    /**
     * Show index page
     */
    public function index()
    {
        $user = Auth::user();

        return view('front.index', ['user' => $user]);
    }
}
