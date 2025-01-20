<?php

namespace App\Services;

use App\Models\User;

class ProfileService extends ImageHandlerService
{
    public function createUser(array $data): User
    {
        if (!empty($data['image'])) {
            $imagePath = $this->saveToDisk($data['image']);
            unset($data['image']);
        }

        $user = User::create($data);

        if (!empty($imagePath)) {
            $user->image()->create([
                'image' => $imagePath,
            ]);
        }

        return $user;
    }

    public function processImageUpdating(User $user, array $data): array
    {
        if (!empty($data['image'])) {
            $imagePath = $this->saveToDisk($data['image']);
            unset($data['image']);

            if (!empty($user->getImagePath())) {
                $this->deleteFromDisk($user->getImagePath());
                $user->image()->update(['image' => $imagePath]);
            } else {
                $user->image()->create(['image' => $imagePath]);
            }
        } elseif (!empty($data['delete_image'])) {
            $this->deleteImage($user);
        }

        if (isset($data['delete_image'])) {
            unset($data['delete_image']);
        }

        return $data;
    }

    public function deleteImage(User $user): void
    {
        if (!empty($user->getImagePath())) {
            $this->deleteFromDisk($user->getImagePath());
            $user->image()->delete();
        }
    }

    public function getPathToSave(): string
    {
        return config('images.user.path_to_save');
    }

    public function getImgParams(): array
    {
        return config('images.user');
    }
}
