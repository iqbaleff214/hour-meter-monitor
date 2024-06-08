<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHourMeterReportRequest;
use App\Models\Equipment;
use App\Models\HourMeterReport;
use App\Models\HourMeterReportDetail;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HourMeterReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pages.hour-meter.index', [
            'reports' => HourMeterReport::with(['details'])->owner($request->user())->latest('created_at')->search($request->query('q'))->paginate(7)->withQueryString(),
            'submitted' => HourMeterReport::query()->availableToday($request->user()),
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
                Equipment::find($equipments[$i])->update(['last_hour_meter' => (int)$hourMeters[$i]]);
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
        $hour_meter->load(['details', 'details.equipment', 'details.equipment.category']);

        $details = [];
        foreach ($hour_meter->details as $detail) {
            $category = $detail->equipment->category->name;
            if (!isset($details[$category])) {
                $details[$category] = [];
            }
            $details[$category][] = $detail;
        }

        return view('pages.hour-meter.show', [
            'report' => $hour_meter,
            'details' => $details,
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
            Log::error($this::class . ': ' . $th->getMessage());

            return back()->with('notification', ['icon' => 'error', 'title' => 'Hour Meter', 'message' => 'Gagal menghapus laporan hour meter!']);
        }
    }

    public function export(HourMeterReport $hour_meter): StreamedResponse|RedirectResponse
    {
        try {
            $filename = $hour_meter->created_at->isoFormat('Y-MM-DD') . '_' . $hour_meter->subsidiary?->name . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];

            return response()->stream(function () use ($hour_meter) {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Kategori',
                    'No',
                    'Jenis Alat',
                    'Equipment Name',
                    'Model',
                    'Serial Number',
                    'Hour Meter',
                    'Tanggal Breakdown',
                    'Detail Breakdown',
                ]);

                $number = 1;
                $lastCategoryId = '';

                $details = $hour_meter->details()->with(['equipment', 'equipment.category'])->orderBy('category_id')->get()->sortBy('equipment.category_id');
                foreach ($details as $detail) {
                    $number = ($lastCategoryId != $detail->equipment?->category_id) ? 1 : $number;
                    $lastCategoryId = $detail->equipment?->category_id;

                    $data = [
                        $detail->equipment?->category?->name ?? '',
                        $number++,
                        $detail->equipment?->code ?? '',
                        $detail->equipment?->brand ?? '',
                        $detail->equipment?->model ?? '',
                        $detail->equipment?->serial_number ?? '',
                        $detail->new_hour_meter ?? '',
                        $detail->created_at->isoFormat('Y-MM-DD'),
                        $detail->service_plan,
                    ];

                    fputcsv($handle, $data);
                }

                fclose($handle);
            }, 200, $headers);
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());

            return redirect()->route('report.hour-meter.index');
        }
    }
}
