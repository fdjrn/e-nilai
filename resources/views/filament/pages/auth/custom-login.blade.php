{{-- resources/views/filament/pages/auth/custom-login.blade.php --}}

<x-filament-panels::page.simple>
    {{-- Header Section --}}
    <div class="fi-simple-header flex flex-col items-center space-y-2 ">
        {{-- Logo --}}
        <img class="fi-logo flex dark:flex h-32" src="{{ asset('images/logo-400x400.png') }}" alt="Logo">
        {{-- School Name --}}
        <p class="fi-simple-header-heading text-center text-sm font-bold tracking-tight text-gray-950 dark:text-white mb-5">
            SMAN 2 CIKARANG UTARA
        </p>
    </div>


    <div class="mt-4 mb-12">
        {{-- Login Caption --}}
        <h1
            class="fi-simple-header-heading text-center text-2xl font-bold tracking-tight text-gray-950 dark:text-white"
        >
            {{ $this->getLoginCaption() }}
        </h1>

        {{-- Login Sub-Caption --}}
        @if (filled($this->getLoginSubCaption()))
            <p
                class="fi-simple-header-subheading mt-2 text-center text-sm text-gray-500 dark:text-gray-400"
            >
                {{ $this->getLoginSubCaption() }}
            </p>
        @endif
    </div>

    {{-- Optional Register Action --}}
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}
            {{ $this->registerAction }}
        </x-slot>
    @endif

    {{-- Hooks sebelum form --}}
    {{ \Filament\Support\Facades\FilamentView::renderHook(
        \Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
        scopes: $this->getRenderHookScopes()
    ) }}

    {{-- Login Form --}}
    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{-- Hooks setelah form --}}
    {{ \Filament\Support\Facades\FilamentView::renderHook(
        \Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
        scopes: $this->getRenderHookScopes()
    ) }}
</x-filament-panels::page.simple>
