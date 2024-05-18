<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number', 'code', 'brand', 'model',
        'last_hour_meter', 'category_id', 'user_id',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function subsidiary(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, string|null $search): Builder {
        return $query->when($search, function(Builder $query) use ($search) {
            return $query->where('serial_number', $search)
                ->orWhere('brand', 'LIKE', $search . '%')
                ->orWhere('model', $search)
                ->orWhere('code', $search);
        });
    }

    public function scopeRender(Builder $query, int $page) {
        return $query->with(['category', 'subsidiary'])->paginate($page)->withQueryString();
    }
}
