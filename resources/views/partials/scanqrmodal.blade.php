<x-filament::modal alignment="center"
    :close-by-clicking-away="false"
    :close-button="false"
    width="3xl"
    id="scaning-modal">
    <div class="p-4 text-center">
        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <div class="fi-modal-content flex flex-col gap-y-4 py-2 px-4">
                    <div class="w-full" wire:ignore>
                        <div id="reader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fi-modal-footer w-full px-6 pb-6">
        <div class="fi-modal-footer-actions gap-3 flex flex-wrap items-center justify-center">
            <button style="--c-400:var(--danger2-400);--c-500:var(--danger2-500);--c-600:var(--danger2-600);"
                class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75
                    focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md
                    gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50
                    dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50"
                    type="button" wire:loading.attr="disabled" wire:target="$dispatch('close-modal', { id: 'scaning-modal' })"
                    wire:click="$dispatch('close-modal', { id: 'scaning-modal' })" id="tutupscan">
                <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white" wire:loading.delay.default="" wire:target="$dispatch('close-modal', { id: 'scaning-modal' })">
                    <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                    <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                </svg>
                <span class="fi-btn-label">
                    Tutup
                </span>
            </button>
        </div>
    </div>
    {{-- <x-slot name="footerActions" alignment="center">
        <button style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);"
            class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75
                focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md
                gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50
                dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50"
                type="button" wire:loading.attr="disabled" wire:target="$dispatch('close-modal', { id: 'scaning-modal' })"
                wire:click="$dispatch('close-modal', { id: 'scaning-modal' })" id="tutupscan">
            <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white" wire:loading.delay.default="" wire:target="$dispatch('close-modal', { id: 'scaning-modal' })">
                <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
            </svg>
            <span class="fi-btn-label">
                Tutup
            </span>
        </button>
    </x-slot> --}}
</x-filament::modal>
