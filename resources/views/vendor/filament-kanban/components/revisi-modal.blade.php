<x-filament-panels::form wire:submit.prevent="revisiModalFormSubmitted">
    <x-filament::modal id="kanban--revisi-modal" :slideOver="$this->getEditModalSlideOver()" :width="$this->getEditModalWidth()">
        <x-slot name="header">
            <x-filament::modal.heading>
                Keterangan Revisi
            </x-filament::modal.heading>
        </x-slot>

        {{ $this->form }}

        <x-slot name="footer">
            <x-filament::button type="submit" wire:target='editModalFormSubmitted'>
                {{$this->getEditModalSaveButtonLabel()}}
            </x-filament::button>

            <x-filament::button color="gray" x-on:click="isOpen = false">
                {{$this->getEditModalCancelButtonLabel()}}
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</x-filament-panels::form>
