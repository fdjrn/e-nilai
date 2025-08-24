<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\LoginResponse as BaseLoginResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse extends BaseLoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = \Auth::user();

        if ($user->hasRole('super-admin')) {
            return redirect()->intended('/admin');
        } else if ($user->hasRole('guru')) {
            return redirect()->intended('/guru');
        }

        return parent::toResponse($request);
    }

}
