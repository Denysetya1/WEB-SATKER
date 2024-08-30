<div>
    {{-- x-cloak x-show="$store.isLoading.value" --}}
    <div x-cloak
    {{-- x-init="
        form = $el.closest('form')
        form?.addEventListener('form-processing-started', (event) => {
            Alpine.store('isLoading').set(true)
        })
        form?.addEventListener('form-processing-finished', () => {
            Alpine.store('isLoading').set(false)
        })
    "  --}}
    x-show="$store.isLoading.value"
    >
        <div class="fi-modal-close-overlay fixed inset-0 z-40 bg-gray-950/50 dark:bg-gray-950/75"></div>
        <div class="fixed z-50 w-full" style="height: 20%; left: 0%; top: 35%">
            <div class=" absolute flex flex-col top-1/2 items-center w-full h-full" style="left: 0%">
                <div class="bounceballbf" style="background-image: url('{{asset('images/logo_ckn_pagimana.png')}}');"></div>
                <div class="bounceball flex justify-center"></div>
                {{-- <div class="mt-2">
                    <x-filament::loading-indicator class="h-5 w-5"/>
                    <div class="text-xl font-bold text-white hidden sm:block">
                        Loading...
                    </div>
                </div> --}}
            </div>
            {{-- <div class="flex gap-x-2 justify-center bg-white border text-primary-800 border-gray-300 dark:border-gray-800 dark:bg-gray-1000 px-3 py-3 sm:py-2 dark:text-white rounded-lg
                drop-shadow-[0_1px_8px_var(--tw-shadow-color)] dark:shadow-gray-600/30 shadow-gray-200
            ">
                <x-filament::loading-indicator class="h-5 w-5"/>
                <div class="text-sm hidden sm:block">
                    Loading...
                </div>
            </div> --}}
        </div>
    </div>
    <div class="text-center text-gray-400 text-sm py-10">
        {{ now()->format('Y') }} &copy; {{ config('app.name') }}
    </div>
    <script>
        document.addEventListener('alpine:init', () => Alpine.store('isLoading', {
            value: false,
            delayTimer: null,
            set(value) {
                clearTimeout(this.delayTimer);
                if (value === false) this.value = false;
                else this.delayTimer = setTimeout(() => this.value = true, 1500);
            }
        }))

        document.addEventListener("livewire:init", () => {
            Livewire.hook('commit.prepare', () => Alpine.store('isLoading').set(true))
            Livewire.hook('commit', ({succeed}) => succeed(() => queueMicrotask(() => Alpine.store('isLoading').set(false))))
        })

        document.addEventListener("form-processing-started", () => {
            Alpine.store('isLoading').set(true)
        })
        document.addEventListener("form-processing-finished", () => {
            Alpine.store('isLoading').set(false)
        })
    </script>

</div>
