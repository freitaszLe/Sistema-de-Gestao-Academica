<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Schedule[] $enrollments
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verifica se o usuário é um administrador.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica se o usuário é um aluno.
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Define o relacionamento Many-to-Many com Schedules (Turmas).
     * ESTE É O MÉTODO QUE ESTAVA CAUSANDO O ERRO.
     */
    public function enrollments()
    {
        return $this->belongsToMany(Schedule::class, 'enrollments', 'student_id', 'schedule_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}