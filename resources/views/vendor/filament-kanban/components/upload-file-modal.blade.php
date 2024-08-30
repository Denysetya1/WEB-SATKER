<x-filament-panels::form wire:submit.prevent="uploadFileModalFormSubmitted">
    <x-filament::modal id="kanban--upload-file-modal" :slideOver="$this->getEditModalSlideOver()" :width="$this->getEditModalWidth()">
        <x-slot name="header">
            <x-filament::modal.heading>
                Upload File
            </x-filament::modal.heading>
        </x-slot>

        {{ $this->form }}

        <x-slot name="footer">
            <x-filament::button type="submit" wire:target='uploadFileModalFormSubmitted'>
                {{$this->getEditModalSaveButtonLabel()}}
            </x-filament::button>

            <x-filament::button color="gray" x-on:click="isOpen = false">
                {{$this->getEditModalCancelButtonLabel()}}
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</x-filament-panels::form>
