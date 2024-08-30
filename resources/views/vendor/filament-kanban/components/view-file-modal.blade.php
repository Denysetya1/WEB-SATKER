<x-filament::modal id="kanban--view-file-modal" :slideOver="$this->getEditModalSlideOver()" :width="$this->getEditModalWidth()">
    <x-slot name="header">
        <x-filament::modal.heading>
            View File
        </x-filament::modal.heading>
    </x-slot>

    {{ $this->fileInfolist }}

    <x-slot name="footer">
        {{-- <x-filament::button type="submit" wire:target='viewFileModalFormSubmitted'>
            {{$this->getEditModalSaveButtonLabel()}}
        </x-filament::button> --}}

        <x-filament::button color="gray" x-on:click="isOpen = false">
            Tutup
        </x-filament::button>
    </x-slot>
</x-filament::modal>
{{-- <x-filament-panels::form wire:submit.prevent="viewFileModalFormSubmitted">
</x-filament-panels::form> --}}
