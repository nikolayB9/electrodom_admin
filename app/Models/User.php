<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\User\GenderEnum;
use App\Enums\User\RoleEnum;
use App\Models\Traits\Filterable;
use App\Services\ProfileService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, Filterable, SoftDeletes, Prunable;

    public function image(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserImage::class);
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
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

    public function getGenderName(): string
    {
        return GenderEnum::getDescription($this->gender);
    }

    public function getRoleName(): string
    {
        return RoleEnum::getDescription($this->role);
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function prunable(): Builder
    {
        return static::onlyTrashed()->where('deleted_at', '<=', now()->subMinute());
    }

    protected function pruning(): void
    {
        foreach ($this->orders()->withTrashed()->select('id')->get() as $order) {
            $order->products()->detach();
            $order->address()->delete();
        }
        $this->orders()->withTrashed()->forceDelete();

        if ($this->address) {
            $this->address()->delete();
        }

        $service = new ProfileService();
        $service->deleteImage($this);
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
