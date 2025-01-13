<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function image(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserImage::class);
    }

    public function getImageUrl(): ?string
    {
        return $this->image ? url('/storage/' . $this->image->image_path) : null;
    }

    public function getImagePath(): ?string
    {
        return $this->image ? $this->image->image_path : null;
    }

    public function deleteImage(): void
    {
        if (!empty($this->image)) {
            Storage::disk('public')->delete($this->getImagePath());
            $this->image()->delete();
        }
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
