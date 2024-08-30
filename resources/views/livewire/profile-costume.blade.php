<div>
    <form wire:submit.prevent="submit" class="space-y-6">

        {{ $this->form }}

        <div class="text-right">
            <x-filament::button type="submit" form="submit" class="align-right">
                Simpan
            </x-filament::button>
        </div>
    </form>
    {{-- <x-filament-breezy::grid-section md=2 title="Personal Information" description="Atur Personal Informasi Anda.">
        <x-filament::card>
        </x-filament::card>
    </x-filament-breezy::grid-section> --}}
</div>
