<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enum\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $append = [
        'avatar_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn () => 'https://ui-avatars.com/api/?name='.$this->name,
        );
    }

    public function isParent(): bool
    {
        return Role::tryFrom($this->role) === Role::PARENT_COMPANY;
    }

    public function isSubsidiary(): bool
    {
        return Role::tryFrom($this->role) === Role::SUBSIDIARY;
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    public function scopeSubsidiary(Builder $query): Builder
    {
        return $query->where('role', Role::SUBSIDIARY);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            return $query->where('name', 'LIKE', $search.'%')
                ->orWhere('email', 'LIKE', $search.'%');
        });
    }

    public function scopeRender(Builder $query, int $page)
    {
        return $query->paginate($page)->withQueryString();
    }
}
