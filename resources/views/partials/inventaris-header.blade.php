<div>
    <div x-data="{qr: false, toggle4() { this.qr = ! this.qr},}">
        <header class="fi-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                    Inventaris BMN
                </h1>
            </div>
            <div class="fi-ac gap-3 flex flex-wrap items-center justify-start shrink-0">
                {{ $this->ruangAction }}

                <button style="--c-400:var(--danube-400);--c-500:var(--danube-500);--c-600:var(--danube-600);"
                    class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75
                        focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md
                        gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50
                        dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action"
                        type="button" id="scanqr" wire:loading.attr="disabled" wire:click="$dispatch('open-modal', { id: 'scaning-modal' })">
                    <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white"
                        wire:loading.delay.default="" wire:target="$dispatch('open-modal', { id: 'scaning-modal' })">
                        <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                        <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                    </svg>
                    <span class="fi-btn-label">
                        Scan QR
                    </span>
                </button>
            </div>
        </header>
        @include('partials.scanqrmodal')
        <x-filament-actions::modals />
    </div>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script type="module">
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            // console.log(`Code matched = ${decodedText}`, decodedResult);
            html5QrcodeScanner.clear()
            @this.call('scanQr', decodedText);
        }

        function onScanFailure(error) {
        }

        let qrboxFunction = function(viewfinderWidth, viewfinderHeight) {
            let minEdgePercentage = 0.7; // 70%
            let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
            let qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
            return {
                width: qrboxSize,
                height: qrboxSize
            };
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: qrboxFunction
            }, false
        );

        Livewire.on('startQR', data => {
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });
        // html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('scanqr').onclick = function(e) {
                // let html5QrcodeScanner = new Html5QrcodeScanner(
                // "reader",
                // { fps: 10, qrbox: {width: 125, height: 125} }, /* verbose= */ false);
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            };
            document.getElementById('tutupscan').onclick = function(e) {
                // let html5QrcodeScanner = new Html5QrcodeScanner(
                // "reader",
                // { fps: 10, qrbox: {width: 125, height: 125} }, /* verbose= */ false);
                html5QrcodeScanner.clear()
            };
        });
    </script>
</div>
