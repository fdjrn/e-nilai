<?php

namespace App\Filament\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login;
use Illuminate\Contracts\Support\Htmlable;
use JetBrains\PhpStorm\NoReturn;

class LoginV2 extends Login
{
    protected static string $view = 'filament.pages.auth.custom-login';

    public function hasLogo(): bool
    {
        return false;
    }

    public function getHeading(): string|Htmlable
    {
        return "";
    }

    public function getLoginCaption(): string|Htmlable
    {
        return 'Welcome Back';
    }

    public function getLoginSubCaption(): string
    {
        return 'Please sign in to continue';
    }
}
