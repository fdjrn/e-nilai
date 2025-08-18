<?php

namespace App\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;
use Illuminate\Contracts\Auth\Authenticatable;

class AccountWidget extends Widget
{
    protected static string $view = 'filament.widgets.account-widget';
    protected int|string|array $columnSpan = 'full';

    public function getUser(): ?Authenticatable
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
        return null;
    }

    public function getAccountMenuItems(): array
    {
        return [
            'profile' => [
                'label' => 'Profile',
                'url' => route('profile'),
                'icon' => 'heroicon-o-user',
            ],
//            'logout' => static::getLogoutItem(),
        ];
    }

//    public static function getLogoutItem(): Action
//    {
//        return Action::make('logout')
//            ->label(__('filament::widgets/account-widget.logout.label'))
//            ->icon('heroicon-o-logout')
//            ->requiresConfirmation(false)
//            ->url(Filament::getLogoutUrl(), shouldOpenInNewTab: false)
//            ->extraAttributes(['onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();"]);
//    }
}
