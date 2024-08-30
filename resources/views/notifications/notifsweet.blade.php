<x-filament-notifications::notification
    :notification="$notification">
    <div class="swal2-container swal2-center swal2-backdrop-show" style="overflow-y: auto;">
        <div aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-popup swal2-modal swal2-icon-success swal2-show"
            tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: flex;flex-direction: column;">
            <div class="swal2-header w-full">
                <ul class="swal2-progress-steps" style="display: none;"></ul>
                @if ($getStatus() == 'success')
                    <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;">
                        <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                        <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
                        <div class="swal2-success-ring"></div>
                        <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                        <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                    </div>
                @elseif ($getStatus() == 'error')
                    <div class="swal2-icon swal2-error swal2-icon-show" style="display: flex;">
                        <span class="swal2-x-mark">
                            <span class="swal2-x-mark-line-left"></span>
                            <span class="swal2-x-mark-line-right"></span>
                        </span>
                    </div>
                @elseif ($getStatus() == 'warning')
                    <div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;"><div class="swal2-icon-content">!</div></div>
                @elseif ($getStatus() == 'info')
                    <div class="swal2-icon swal2-info swal2-icon-show" style="display: flex;"><div class="swal2-icon-content">!</div></div>
                @endif
                <img class="swal2-image" style="display: none;">
                <h2 class="swal2-title" id="swal2-title" style="display: block;">{{ $getTitle() }}</h2>
                <button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button>
            </div>
            <div class="swal2-actions" style="">
                <div class="swal2-loader"></div>
                <button type="button" class="swal2-confirm swal2-styled" aria-label="" style="display: inline-block;"
                    x-on:click="close">OK</button>
                <button type="button" class="swal2-deny swal2-styled" aria-label="" style="display: none;">No</button>
                <button type="button" class="swal2-cancel swal2-styled" aria-label="" style="display: none;">Cancel</button>
            </div>
            <div class="swal2-footer" style="display: none;"></div>
            <div class="swal2-timer-progress-bar-container">
                <div class="swal2-timer-progress-bar" style="transition: width 2s linear 0s; width: 0%;"></div>
            </div>
            {{-- <button type="button" x-on:click="close">
                X
            </button> --}}
        </div>
    </div>
</x-filament-notifications::notification>
