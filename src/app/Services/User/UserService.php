<?php

namespace App\Services\User;

use App\Models\User\User;
use Illuminate\Http\UploadedFile;

class UserService
{
    /**
     * Change the password on the user that is passed
     * to the method
     *
     * @param User $user
     * @param string $newPassword
     * @return User
     */
    public function changePassword(User $user, string $newPassword): User
    {
        $user->password = $newPassword;
        $user->save();

        return $user;
    }

    /**
     * Update user profile information and avatar if it's passed
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateProfile(User $user, array $updateData, ?UploadedFile $avatarFile): User
    {
        $user->update($updateData);

        return $user;
    }
}
