<div>
    <x-filament-panels::page.simple>
        <x-slot name="heading">
            <h1 class="fi-simple-header-heading text-center text-2xl font-bold tracking-tight text-gray-950 dark:text-white">LOGIN</h1>
        </x-slot>
        <x-slot name="subheading">
            <span class="font-semibold text-sm text-custom-600 dark:text-custom-400" style="--c-400:var(--primary-400);--c-600:var(--primary-600);">
                Jika mengalami kendala silahkan hubungi admin
            </span>
            {{-- {{ __('filament-panels::pages/auth/login.actions.register.before') }} --}}

            {{-- {{ $this->registerAction }} --}}
        </x-slot>
        @if (filament()->hasRegistration())
        @endif

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

        <x-filament-panels::form wire:submit="authenticate">
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament-panels::form>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
    </x-filament-panels::page.simple>
</div>
