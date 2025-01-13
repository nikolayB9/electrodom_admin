<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public static function updateImage(User $user, array $data): array
    {
        if (!empty($data['image'])) {
            $image_path = Storage::disk('public')->put('/images', $data['image']);
            unset($data['image']);
            if (isset($data['delete_image'])) {
                unset($data['delete_image']);
            }

            if (!empty($user->image)) {
                Storage::disk('public')->delete($user->getImagePath());
                $user->image()->update(['image_path' => $image_path]);
            } else {
                $user->image()->create(['image_path' => $image_path]);
            }
        } elseif (!empty($data['delete_image'])) {
            $user->deleteImage();
            unset($data['delete_image']);
        }

        return $data;
    }
}
