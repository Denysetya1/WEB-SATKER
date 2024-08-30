<div id="superlarge-modal-size-preview" class="modal group bg-black/60 transition-[visibility,opacity] w-screen h-screen fixed left-0 top-0 [&:not(.show)]:duration-[0s,0.2s] [&:not(.show)]:delay-[0.2s,0s] [&:not(.show)]:invisible [&:not(.show)]:opacity-0 [&.show]:visible [&.show]:opacity-100 [&.show]:duration-[0s,0.4s] overflow-y-auto modal-overlap overflow-y-auto" data-tw-backdrop="static"
        tabindex="-1" aria-hidden="false" style="margin-top: 0px; margin-left: 0px; padding-left: 0px; z-index: 300;"
        x-data="{ openModal: @entangle('editRuangModal'), toggle2() { this.openModal = ! this.openModal} }"
        x-bind:class="openModal ? 'show' : ''"
    >
        <div class="w-[90%] mx-auto bg-white relative rounded-md shadow-md transition-[margin-top,transform] duration-[0.4s,0.3s] -mt-16 group-[.show]:mt-16 group-[.modal-static]:scale-[1.05] dark:bg-darkmode-600 sm:w-[600px] lg:w-[900px]">
            <div class="absolute z-[300] w-full h-full bg-opacity-80 bg-slate-200 flex flex-col items-center justify-center"
                wire:loading.flex wire:target="closeModalEditRuang"
                wire:ignore
            >
                <x-base.loading-icon
                    class="w-8 h-8"
                    icon="ball-triangle"
                />
            </div>
            <div class="fi-modal-header flex px-6 pt-6 gap-x-5">
                <div class="absolute end-4 top-4">
                    <button style="--c-300:var(--gray-300);--c-400:var(--gray-400);--c-500:var(--gray-500);--c-600:var(--gray-600);"
                        class="fi-icon-btn relative flex items-center justify-center rounded-lg outline-none transition duration-75
                            focus-visible:ring-2 disabled:pointer-events-none disabled:opacity-70 -m-1.5 h-9 w-9 fi-color-gray
                            text-gray-400 hover:text-gray-500 focus-visible:ring-primary-600 dark:text-gray-500
                            dark:hover:text-gray-400 dark:focus-visible:ring-primary-500 fi-modal-close-btn" title="Tutup" type="button"
                            tabindex="-1"
                            {{-- wire:click="closeModalEditRuang" --}}
                            @click="toggle2()"
                            >
                        <span class="sr-only">
                            Tutup
                        </span>
                        <svg class="fi-icon-btn-icon h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="">
                    <h2 class="fi-modal-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                        Ubah Ruang
                    </h2>
                </div>
            </div>
            <div class="p-4 text-center">
                <div class="grid grid-cols-12 gap-6">
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <form wire:submit="updateRoom">
                            <div class="fi-modal-content flex flex-col gap-y-4 py-6 px-6">
                                {{ $this->editRoomForm }}
                            </div>
                            <div class="fi-modal-footer w-full px-6 fi-sticky sticky bottom-0 border-t border-gray-200 bg-white py-5 dark:border-white/10 dark:bg-gray-900 mt-auto">
                                <div class="fi-modal-footer-actions gap-3 flex flex-wrap items-center">
                                    <button x-data="{
                                                form: null,
                                                isUploadingFile: false,
                                            }" x-init="
                                                form = $el.closest('form')

                                                form?.addEventListener('file-upload-started', () => {
                                                    isUploadingFile = true
                                                })

                                                form?.addEventListener('file-upload-finished', () => {
                                                    isUploadingFile = false
                                                })
                                            " x-bind:class="{ 'enabled:opacity-70 enabled:cursor-wait': isUploadingFile }"
                                            style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);"
                                            class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition
                                            duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-size-md
                                            fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white
                                            hover:bg-custom-500 dark:bg-custom-500 dark:hover:bg-custom-400 focus-visible:ring-custom-500/50
                                            dark:focus-visible:ring-custom-400/50 fi-ac-btn-action" type="submit" wire:loading.attr="disabled"
                                            x-bind:disabled="isUploadingFile">
                                        <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon h-5 w-5" wire:loading.delay.default="" wire:target="updateRoom">
                                            <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                                        </svg>
                                        <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon h-5 w-5" x-show="isUploadingFile" style="display: none;">
                                            <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                                        </svg>
                                        <span x-show="! isUploadingFile" class="fi-btn-label">
                                            Save
                                        </span>
                                        <span x-show="isUploadingFile" style="display: none;">
                                            Menyimpan Perubahan...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
