<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'max_value', 'service_plan',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch(Builder $query, string|null $search): Builder {
        return $query->when($search, function(Builder $query) use ($search) {
            return $query->where('service_plan', 'LIKE', $search . '%');
        });
    }

    public function scopeRender(Builder $query, int $page) {
        return $query->orderBy('max_value', 'asc')->paginate($page)->withQueryString();
    }
}
