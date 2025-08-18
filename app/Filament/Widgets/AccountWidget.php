<?php

namespace App\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class AccountWidget extends Widget
{
    protected static string $view = 'filament.widgets.account-widget';
    protected int|string|array $columnSpan = 'full';

    public function getUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Filament::auth()->user();
    }

    public function getUserName(): string
    {
        return $this->getUser()?->name ?? '';
    }

    public function getUserEmail(): ?string
    {
        return $this->getUser()?->email;
    }

    public function getUserAvatarUrl(): ?string
    {
        return null; // Bisa diganti ke URL avatar user, misalnya pakai Gravatar atau field di DB
    }

    public function getAccountMenuItems(): array
    {
        return [
            'profile' => [
                'label' => 'Profile',
                'url' => route('profile'), // Pastikan route ini ada
                'icon' => 'heroicon-o-user',
            ],
            'logout' => static::getLogoutItem(),
        ];
    }

    public static function getLogoutItem(): array
    {
        return [
            'label' => __('filament::widgets/account-widget.logout.label'),
//            'url' => Filament::getLogoutUrl(),
            'action' => Filament::getLogoutUrl(),
            'icon' => 'heroicon-o-logout',
            'shouldOpenInNewTab' => false,
        ];
    }
}
