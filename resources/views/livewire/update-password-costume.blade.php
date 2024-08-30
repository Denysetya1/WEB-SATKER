<div>
    <x-filament-breezy::grid-section md=2 :title="__('filament-breezy::default.profile.password.heading')" :description="__('Ubah Password Anda Di sini')">
        <x-filament::card>
            <form wire:submit.prevent="submit" class="space-y-6">

                {{ $this->form }}

                <div class="text-right">
                    <x-filament::button type="submit" form="submit" class="align-right">
                        {{ __('filament-breezy::default.profile.password.submit.label') }}
                    </x-filament::button>
                </div>
            </form>
        </x-filament::card>
    </x-filament-breezy::grid-section>
</div>
