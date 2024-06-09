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

    public function scopeAvailableToday(Builder $query, User|null $user): bool
    {
        return $query->when($user, function (Builder $query, User $user) {
                return $query->where('user_id', $user->id);
            })->whereDate('created_at', now())->count() <= 0 && $user?->isSubsidiary();
    }

    public function scopeOwner(Builder $query, ?User $subsidiary)
    {
        return $query->when($subsidiary?->isSubsidiary(), function (Builder $query) use ($subsidiary) {
            return $query->where('user_id', $subsidiary->id);
        });
    }

    public function scopeFilter(Builder $query, ?string $date, ?int $subsidiaryId)
    {
        return $query->when($date, function (Builder $query) use ($date) {
            return $query->whereDate('created_at', $date);
        })->when($subsidiaryId, function (Builder $query) use ($subsidiaryId) {
            return $query->where('user_id', $subsidiaryId);
        });
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            return $query
                ->whereHas('subsidiary', function (Builder $query) use ($search) {
                    return $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhere('title', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeRender(Builder $query, int $page)
    {
        return $query->with(['detail', 'subsidiary'])->paginate($page)->withQueryString();
    }
}
