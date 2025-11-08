<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     return match ($panel->getId()) {
    //         'admin'      => $this->hasRole('admin'),
    //         'instructor' => $this->hasRole('instructor'),
    //         'viewer'     => $this->hasRole('viewer'),
    //         default      => false,
    //     };
    // }

     public function canAccessPanel(Panel $panel): bool
    {
        // ✅ Allow admin to access the admin panel
        if ($panel->getId() === 'admin' && $this->hasRole('admin')) {
            return true;
        }

        // ✅ Allow instructor to access instructor panel (if you have it)
        if ($panel->getId() === 'instructor' && $this->hasRole('instructor')) {
            return true;
        }

        // ❌ Otherwise deny accesss
        return false;
    }

    public function activity(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
