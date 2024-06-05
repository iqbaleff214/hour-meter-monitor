<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HourMeterReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id',
    ];

    public function subsidiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(HourMeterReportDetail::class);
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
            return $query->where('title', 'LIKE', '%'.$search.'%');
        });
    }

    public function scopeRender(Builder $query, int $page)
    {
        return $query->with(['detail', 'subsidiary'])->paginate($page)->withQueryString();
    }
}
