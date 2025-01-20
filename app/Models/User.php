<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function image(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserImage::class);
    }

    public function getImagePath(): ?string
    {
        return UserImage::where('user_id', $this->id)
            ->select('image')
            ->pluck('image')
            ->first();
    }

    public function getImageUrl(): ?string
    {
        $imagePath = $this->getImagePath();
        return $imagePath ? url('/storage/' . $imagePath) : null;
    }

    public function getGender(): string
    {
        return $this->gender->value;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'phone_number',
        'gender',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'gender' => GenderEnum::class,
            'role' => RoleEnum::class,
        ];
    }
}
