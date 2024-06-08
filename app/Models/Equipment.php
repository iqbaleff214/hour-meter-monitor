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
        'serial_number', 'code', 'brand', 'model', 'condition',
        'last_hour_meter', 'category_id', 'user_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subsidiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOwner(Builder $query, ?User $subsidiary)
    {
        return $query->when($subsidiary?->isSubsidiary(), function (Builder $query) use ($subsidiary) {
            return $query->where('user_id', $subsidiary->id);
        });
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            return $query->where('serial_number', 'LIKE', $search.'%')
                ->orWhere('brand', 'LIKE', $search.'%')
                ->orWhere('model', 'LIKE', $search.'%')
                ->orWhere('code', 'LIKE', $search.'%')
                ->orWhereHas('category', function (Builder $query) use ($search) {
                    return $query->where('name', 'LIKE', $search.'%');
                })
                ->orWhereHas('subsidiary', function (Builder $query) use ($search) {
                    return $query->where('name', 'LIKE', $search.'%');
                });
        });
    }

    public function scopeRender(Builder $query, int $page)
    {
        return $query->with(['category', 'subsidiary'])->paginate($page)->withQueryString();
    }
}
