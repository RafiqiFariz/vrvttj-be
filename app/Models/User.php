<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'photo',
        'gender',
        'address',
        'religion',
        'place_of_birth',
        'date_of_birth',
        'role_id',
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

    protected $with = ['student', 'lecturer'];

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function student(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function lecturer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Lecturer::class);
    }
}
