<x-filament-panels::page>
    <div x-data wire:ignore.self class="md:flex overflow-x-auto gap-4 pb-4" style="height: fit-content">
        @foreach($statuses as $status)
            @include(static::$statusView)
        @endforeach

        <div wire:ignore>
            @include(static::$scriptsView)
        </div>
    </div>

    <x-filament-kanban::edit-record-modal2/>
    <x-filament-kanban::revisi-modal/>
    <x-filament-kanban::upload-file-modal/>
    <x-filament-kanban::view-file-modal/>
    {{-- @unless($disableEditModal)
    @endunless --}}
</x-filament-panels::page>
