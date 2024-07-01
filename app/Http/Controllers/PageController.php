<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\HourMeterReport;
use App\Models\HourMeterReportDetail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PageController extends Controller
{
    public function welcome(Request $request): View
    {
        return view('welcome');
    }

    public function dashboard(Request $request): View
    {
        $start7DaysAgo = now()->subDays(6);

        $pmLast7Days = HourMeterReportDetail::whereHas('report', function (Builder $query) use ($request) {
            return $query->when($request->user()->isSubsidiary(), function (Builder $query) use ($request) {
                return $query->where('user_id', $request->user()->id);
            });
        })->selectRaw('DISTINCT preventive_maintenance_hour_meter')
            ->orderBy('preventive_maintenance_hour_meter')
            ->get()
            ->pluck('preventive_maintenance_hour_meter');
        $reportLast7DaysQuery = HourMeterReportDetail::whereHas('report', function (Builder $query) use ($request) {
            return $query->when($request->user()->isSubsidiary(), function (Builder $query) use ($request) {
                return $query->where('user_id', $request->user()->id);
            });
        })->whereDate('created_at', '>=', $start7DaysAgo)
            ->selectRaw("DATE(created_at) as date")
            ->groupByRaw('DATE(created_at)');
        foreach ($pmLast7Days as $pm) {
            $reportLast7DaysQuery->addSelect(DB::raw("SUM(CASE WHEN preventive_maintenance_hour_meter = {$pm} THEN 1 ELSE 0 END) AS `pm_{$pm}`"));
        }
        $reportLast7Days = $reportLast7DaysQuery->get();
        $reportPreviousWeek = HourMeterReportDetail::whereHas('report', function (Builder $query) use ($request) {
            return $query->when($request->user()->isSubsidiary(), function (Builder $query) use ($request) {
                return $query->where('user_id', $request->user()->id);
            });
        })->whereDate('created_at', '>=', now()->subDays(13))
            ->whereDate('created_at', '<=', now()->subDays(7))
            ->count();

        $mappedReportLast7Days = [];
        foreach ($reportLast7Days as $report) {
            $mappedReportLast7Days[Carbon::parse($report->date)->format('d M')] = $report;
        }

        $formattedReportLast7Days = [
            'series' => [
                ['name' => 'Dilaporkan', 'data' => []],
            ],
            'categories' => [],
            'total' => 0,
            'totalPrevious' => $reportPreviousWeek,
        ];

        $formattedReportConditionLast7Days = [
            'series' => [],
            'categories' => [],
        ];
        foreach ($pmLast7Days as $pm) {
            $formattedReportConditionLast7Days['series'][] = [
                'name' => 'PM ' . $pm,
                'data' => [],
            ];
        }

        foreach (CarbonPeriod::create($start7DaysAgo, now()) as $date) {
            $dateMonth = $date->format('d M');

            $formattedReportLast7Days['categories'][] = $dateMonth;
            $formattedReportLast7Days['series'][0]['data'][] = isset($mappedReportLast7Days[$dateMonth]) ? (int)$mappedReportLast7Days[$dateMonth]->total : 0;
            $formattedReportLast7Days['total'] += isset($mappedReportLast7Days[$dateMonth]) ? (int)$mappedReportLast7Days[$dateMonth]->total : 0;

            $formattedReportConditionLast7Days['categories'][] = $dateMonth;
            foreach ($pmLast7Days as $i => $pm) {
                $formattedReportConditionLast7Days['series'][$i]['data'][] = isset($mappedReportLast7Days[$dateMonth]) ? $mappedReportLast7Days[$dateMonth]->{'pm_' . $pm} : 0;
            }
        }
        $formattedReportLast7Days['totalIncrement'] = $this->incrementPercentage($reportPreviousWeek, $formattedReportLast7Days['total']);

        $totalEquipment = Equipment::owner($request->user())
            ->selectRaw('brand, COUNT(id) as total')
            ->groupBy('brand')
            ->orderByRaw('total desc')
            ->limit(3)
            ->get();
        $otherEquipment = Equipment::owner($request->user())->whereNotIn('brand', $totalEquipment->pluck('brand'))->count();

        if (count($totalEquipment) === 0) {
            $totalEquipment = [(object)['brand' => '-', 'total' => 0], (object)['brand' => '-', 'total' => 0], (object)['brand' => '-', 'total' => 0],];
        }

        return view('pages.dashboard', [
            'submitted' => HourMeterReport::query()->availableToday($request->user()),
            'chart' => [
                'equipment_report' => $formattedReportLast7Days,
                'condition_report' => $formattedReportConditionLast7Days,
            ],
            'summary' => [
                'top3' => $totalEquipment,
                'other' => $otherEquipment,
            ],
        ]);
    }

    private function incrementPercentage(int|float $old, int|float $new): float
    {
        if ($old === 0 and $new === 0) {
            return 0;
        }

        if ($old === 0) {
            return 100;
        }

        if ($new === 0) {
            return -100;
        }

        $diff = $new - $old;
        $percentage = $diff / $old * 100;

        return (float)number_format($percentage, 2);
    }
}
