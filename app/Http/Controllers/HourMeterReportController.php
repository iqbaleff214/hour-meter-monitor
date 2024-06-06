<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHourMeterReportRequest;
use App\Http\Requests\UpdateHourMeterReportRequest;
use App\Models\Equipment;
use App\Models\HourMeterReport;
use App\Models\HourMeterReportDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HourMeterReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pages.hour-meter.index', [
            'reports' => HourMeterReport::query()->search($request->query('q'))->paginate(7)->withQueryString(),
            'submitted' => HourMeterReport::query()->availableToday(),
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
    public function store(StoreHourMeterReportRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $report = HourMeterReport::create([
                'title' => now(),
                'user_id' => $request->user()->id,
            ]);

            $equipments = $request->input('equipment_id');
            $hourMeters = $request->input('new_hour_meter');
            $servicePlans = $request->input('service_plan');

            $reportDetail = [];
            for ($i = 0; $i < count($equipments); $i++) {
                $reportDetail[] = [
                    'hour_meter_report_id' => $report->id,
                    'equipment_id' => $equipments[$i],
                    'new_hour_meter' => $hourMeters[$i],
                    'service_plan' => $servicePlans[$i],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            HourMeterReportDetail::insert($reportDetail);

            for ($i = 0; $i < count($equipments); $i++) {
                Equipment::find($equipments[$i])->update(['last_hour_meter' => (int) $hourMeters[$i]]);
            }

            DB::commit();

            return redirect()->route('report.hour-meter.index')->with('notification', ['icon' => 'success', 'title' => 'Hour Meter', 'message' => 'Berhasil menambahkan laporan hour meter!']);
        } catch (\Throwable $th) {
            Log::error($this::class . ': ' . $th->getMessage());
            DB::rollBack();

            return back()->with('notification', ['icon' => 'error', 'title' => 'Hour Meter', 'message' => 'Gagal menambahkan laporan hour meter!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HourMeterReport $hour_meter): View
    {
        $hour_meter->load(['details', 'details.equipment']);
        return view('pages.hour-meter.show', [
            'report' => $hour_meter,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HourMeterReport $hour_meter): RedirectResponse
    {
        try {
            $hour_meter->delete();

            return back()->with('notification', ['icon' => 'success', 'title' => 'Hour Meter', 'message' => 'Berhasil menghapus laporan hour meter!']);
        } catch (\Throwable $th) {
            Log::error($this::class.': '.$th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Hour Meter', 'message' => 'Gagal menghapus laporan hour meter!']);
        }
    }
}
