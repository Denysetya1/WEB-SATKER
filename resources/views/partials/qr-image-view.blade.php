<div>
    <div style="--cols-default: repeat(1, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
        <div style="--col-span-default: span 1 / span 1;" class="col-[--col-span-default]">
            <div class="fi-in-entry-wrp">
                <div class="grid gap-y-2">
                    <div class="flex items-center justify-between gap-x-3">
                        <dt class="fi-in-entry-wrp-label inline-flex items-center gap-x-3">
                            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                            </span>
                        </dt>
                    </div>

                    <div class="grid gap-y-2">
                        <dd class="">
                            <div class="fi-in-image flex items-center gap-x-2.5">
                                <div class="flex flex-wrap gap-1.5">
                                    <img src="{{ asset('storage/Photo-QR/'.$getState()) }}" style="height: 16rem;" class="max-w-none object-cover object-center ring-white dark:ring-gray-900" alt="Foto QR" loading="lazy">
                                </div>
                            </div>
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

