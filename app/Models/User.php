<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    public const ADMIN = 'admin';
    public const PARTICIPANT = 'participant';
    public const TRAINER = 'trainer';

    protected $fillable = ['name', 'email', 'password', 'role', 'photo'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function participant(): HasOne
    {
        return $this->hasOne(Participant::class, 'user_id');
    }

    public function trainer(): HasOne
    {
        return $this->hasOne(Trainer::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN;
    }

    /** Waar de gebruiker na het inloggen naartoe gaat (eigen scherm per rol). */
    public function homeUrl(): string
    {
        return match ($this->role) {
            self::ADMIN => route('admin.dashboard'),
            self::TRAINER => route('trainer.dashboard'),
            default => route('participant.dashboard'),
        };
    }

    public function photoUrl(): ?string
    {
        return $this->photo ? Storage::disk('public')->url($this->photo) : null;
    }
}
