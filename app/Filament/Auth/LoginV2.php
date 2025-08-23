<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login;
use Illuminate\Contracts\Support\Htmlable;

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
