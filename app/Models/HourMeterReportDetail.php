<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HourMeterReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'hour_meter_report_id', 'equipment_id', 'new_hour_meter', 'service_plan',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(HourMeterReport::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}