<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HourMeterReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'hour_meter_report_id', 'equipment_id', 'new_hour_meter', 'service_plan',
        'condition', 'content', 'preventive_maintenance_hour_meter', 'category_rules_id',
    ];

    protected $casts = [
        'content' => 'object',
    ];

    public function rule(): BelongsTo
    {
        return $this->belongsTo(CategoryRule::class, 'category_rules_id');
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(HourMeterReport::class, 'hour_meter_report_id');
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
