<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'min_value', 'max_value', 'service_plan', 'content',
    ];

    protected $appends = [
        'range_value',
    ];

    protected $casts = [
        'content' => 'object',
    ];

    public function rangeValue(): Attribute
    {
        return new Attribute(
            get: fn() => $this->min_value . '-' . $this->max_value,
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            return $query->where('service_plan', 'LIKE', $search.'%');
        });
    }

    public function scopeRender(Builder $query, int $page)
    {
        return $query->orderBy('min_value', 'asc')->paginate($page)->withQueryString();
    }
}
