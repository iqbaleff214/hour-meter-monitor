<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHourMeterReportRequest;
use App\Http\Requests\UpdateHourMeterReportRequest;
use App\Models\HourMeterReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HourMeterReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pages.hour-meter.index', [
            'reports' => HourMeterReport::query()->paginate(7)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.hour-meter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHourMeterReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HourMeterReport $hourMeterReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HourMeterReport $hourMeterReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHourMeterReportRequest $request, HourMeterReport $hourMeterReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HourMeterReport $hourMeterReport)
    {
        //
    }
}
