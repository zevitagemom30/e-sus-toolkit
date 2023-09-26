<?php

namespace OM30\EsusToolkit\Helpers;

use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function getClassShortName(string $class)
    {
        $classParts = explode('\\', $class);
        return end($classParts);
    }

    public static function createDefaultJsonToResponse(
        bool $status, $content = null
    )
    {
        return ['status' => $status, 'body' => $content];
    }

    public static function getUserId()
    {
        return Auth::id();
    }

    public static function getUser()
    {
        return Auth::user();
    }
}
