<?php

namespace App\Http\Controllers;

use App\Services\LandingPageService;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(LandingPageService $landing): View
    {
        return view('landing.index', $landing->data());
    }
}
