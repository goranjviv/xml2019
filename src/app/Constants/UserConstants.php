<?php

namespace App\Constants;

use Illuminate\Support\Str;

class UserConstants
{
    const ROLE_AUTHOR = 'author';
    const ROLE_REVIEWER = 'reviewer';
    const ROLE_EDITOR = 'editor';

    const ROLES = [
        self::ROLE_AUTHOR,
        self::ROLE_REVIEWER,
        self::ROLE_EDITOR,
    ];

    const AVATAR_PATH = '/users/';

    const AVATAR_EXTENSION = 'jpg';

    const FORGOT_PASSWORD_LENGTH = 191;

    const VERIFY_EMAIL_TOKEN_LENGTH = 191;

    const AVATAR_WIDTH = 200;

    const AVATAR_HEIGHT = 200;

    /**
     * Format the avatar storage path
     *
     * @param integer $userId
     * @return string
     */
    public static function formatAvatarPath(int $userId): string
    {
        return self::AVATAR_PATH . $userId . '/' . Str::random() . '.' . self::AVATAR_EXTENSION;
    }
}
