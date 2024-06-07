<?php

namespace App\Http\Controllers;

use App\Models\HourMeterReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function welcome(Request $request): View
    {
        return view('welcome');
    }

    public function dashboard(Request $request): View
    {
        return view('pages.dashboard', [
            'submitted' => HourMeterReport::query()->availableToday($request->user()),
        ]);
    }
}
