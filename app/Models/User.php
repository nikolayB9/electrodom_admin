<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\User\GenderEnum;
use App\Enums\User\RoleEnum;
use App\Models\Traits\Filterable;
use App\Services\ProfileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, Filterable;

    public function image(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserImage::class);
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function getImagePath(): ?string
    {
        return UserImage::where('user_id', $this->id)
            ->pluck('image')
            ->first();
    }

    public function hasImage(): bool
    {
        return !empty($this->getImagePath());
    }

    public function getImageUrl(): string
    {
        $imagePath = $this->getImagePath();
        return $imagePath ? url('/storage/' . $imagePath) : url(ProfileService::getPathToDefault());
    }

    public function getGender(): string
    {
        return $this->gender->value;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    protected $guarded = false;

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
