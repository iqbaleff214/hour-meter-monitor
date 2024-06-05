<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function rules(): HasMany
    {
        return $this->hasMany(CategoryRule::class);
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            return $query->where('name', 'LIKE', $search.'%');
        });
    }

    public function scopeRender(Builder $query, int $page)
    {
        return $query->withCount('equipment')->paginate($page)->withQueryString();
    }
}
