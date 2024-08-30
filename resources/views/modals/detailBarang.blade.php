<div id="superlarge-modal-size-preview" class="modal group bg-black/60 transition-[visibility,opacity] w-screen h-screen fixed left-0 top-0 [&:not(.show)]:duration-[0s,0.2s] [&:not(.show)]:delay-[0.2s,0s] [&:not(.show)]:invisible [&:not(.show)]:opacity-0 [&.show]:visible [&.show]:opacity-100 [&.show]:duration-[0s,0.4s] overflow-y-auto modal-overlap overflow-y-auto" data-tw-backdrop="static"
    tabindex="-1" aria-hidden="false" style="margin-top: 0px; margin-left: 0px; padding-left: 0px; z-index: 300;"
    x-data="{ openModal: @entangle('detailBarangModal'), toggle3() { this.openModal = ! this.openModal} }"
    x-bind:class="openModal ? 'show' : ''">
    <div class="w-[90%] mx-auto bg-white relative rounded-md shadow-md transition-[margin-top,transform] duration-[0.4s,0.3s] -mt-16 group-[.show]:mt-16 group-[.modal-static]:scale-[1.05] dark:bg-darkmode-600 sm:w-[600px] lg:w-[900px]">
        <div class="absolute z-[300] w-full h-full bg-opacity-80 bg-slate-200 flex flex-col items-center justify-center"
            wire:loading.flex wire:target="closeModalEditRuang" wire:ignore
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
                        @click="toggle3()"
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
                    Detail Barang
                </h2>
            </div>
        </div>
        <div class="p-4 text-center">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="fi-modal-content flex flex-col gap-y-4 py-2 px-4">
                        @if ($detailBarang != null)
                            <div style="--cols-default: repeat(1, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                <div style="--col-span-default: 1 / -1;" class="col-[--col-span-default]">
                                    <div>
                                        <div style="--cols-default: repeat(8, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6 mb-4">
                                            <div style="--col-span-default: span 3 / span 3;" class="col-[--col-span-default]">
                                                <section x-data="{ isCollapsed:  false ,}" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10" id="barangData.foto-barang" data-has-alpine-state="true">
                                                    <header class="fi-section-header flex flex-col gap-3 overflow-hidden sm:flex-row sm:items-center px-6 py-2">
                                                        <div class="grid flex-1 gap-y-1">
                                                            <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                                Foto QR
                                                            </h3>
                                                        </div>
                                                    </header>
                                                    <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                                        <div class="fi-section-content p-4">
                                                            <div style="--cols-default: repeat(1, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                                                <x-base.image-zoom
                                                                    class="w-full image-fit rounded-md mt-2 mx-auto"
                                                                    {{-- src="{{asset('storage/Photo-QR/'.$detailBarang['qr_path']).'.svg'}}" --}}
                                                                    src="{{asset('storage/Photo-QR/'.$detailBarang['qr_path']).'.png'}}"
                                                                    alt="{{$detailBarang['nama']}}"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                            <div style="--col-span-default: span 5 / span 5;" class="col-[--col-span-default]">
                                                <section x-data="{ isCollapsed:  false ,}" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10" id="barangData.foto-barang" data-has-alpine-state="true">
                                                    <header class="fi-section-header flex flex-col gap-3 overflow-hidden sm:flex-row sm:items-center px-6 py-2">
                                                        <div class="grid flex-1 gap-y-1">
                                                            <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                                Foto Barang
                                                            </h3>
                                                        </div>
                                                    </header>
                                                    <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                                        <div class="fi-section-content p-4">
                                                            <div style="--cols-default: repeat(1, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                                                <x-base.image-zoom
                                                                    class="w-full image-fit rounded-md mt-2 mx-auto max-h-[270px] min-h-[270px]"
                                                                    src="{{asset('storage/'.$detailBarang['photo_path'])}}"
                                                                    alt="{{$detailBarang['nama']}}"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                        <div style="--cols-default: repeat(8, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                            <div style="--col-span-default: span 8 / span 8;" class="col-[--col-span-default]">
                                                <section x-data="{isCollapsed:  false ,}" class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10" id="barangData.detail-barang" data-has-alpine-state="true">
                                                    <header class="fi-section-header flex flex-col gap-3 overflow-hidden sm:flex-row sm:items-center px-6 py-2">
                                                        <div class="grid flex-1 gap-y-1">
                                                            <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                                Detail Barang
                                                            </h3>
                                                        </div>
                                                    </header>
                                                    <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                                        <div class="fi-section-content p-4">
                                                            <div style="--cols-default: repeat(1, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                                                <div style="--col-span-default: 1 / -1;" class="col-[--col-span-default]">
                                                                    <div>
                                                                        <div style="--cols-default: repeat(12, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                                                            <div style="--col-span-default: span 6 / span 6;" class="col-[--col-span-default]" wire:key="jRakoYuSPj5dSGZuJxsZ.barangData.nama.Filament\Forms\Components\TextInput">
                                                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                                    <div class="grid gap-y-2">
                                                                                        <div class="flex items-center justify-between gap-x-3 ">
                                                                                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="barangData.nama">
                                                                                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                                                    Nama Barang
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="grid gap-y-2">
                                                                                            <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-text-input overflow-hidden">
                                                                                                <div class="min-w-0 flex-1">
                                                                                                    <p class="fi-input block w-full text-xl border-none py-1.5 text-gray-950 transition
                                                                                                        duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500
                                                                                                        disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)]
                                                                                                        dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400
                                                                                                        dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)]
                                                                                                        sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" type="text">
                                                                                                        {{$detailBarang['nama']}}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="--col-span-default: span 6 / span 6;" class="col-[--col-span-default]" wire:key="jRakoYuSPj5dSGZuJxsZ.barangData.kode.Filament\Forms\Components\TextInput">
                                                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                                    <div class="grid gap-y-2">
                                                                                        <div class="flex items-center justify-between gap-x-3 ">
                                                                                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="barangData.kode">
                                                                                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                                                    Kode Barang
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="grid gap-y-2">
                                                                                            <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-text-input overflow-hidden">
                                                                                                <div class="min-w-0 flex-1">
                                                                                                    <p class="fi-input block w-full border-none py-1.5 text-base font-bold text-green-700 transition
                                                                                                        duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500
                                                                                                        disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)]
                                                                                                        dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400
                                                                                                        dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)]
                                                                                                        sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" type="text">
                                                                                                        {{$detailBarang['kode']}}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="--col-span-default: span 6 / span 6;" class="col-[--col-span-default]" wire:key="jRakoYuSPj5dSGZuJxsZ.barangData.merk.Filament\Forms\Components\TextInput">
                                                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                                    <div class="grid gap-y-2">
                                                                                        <div class="flex items-center justify-between gap-x-3 ">
                                                                                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="barangData.merk">
                                                                                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                                                    Merk/Type
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="grid gap-y-2">
                                                                                            <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-text-input overflow-hidden">
                                                                                                <div class="min-w-0 flex-1">
                                                                                                    <p class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition
                                                                                                        duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500
                                                                                                        disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)]
                                                                                                        dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400
                                                                                                        dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)]
                                                                                                        sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" type="text">
                                                                                                        {{$detailBarang['merk']}}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="--col-span-default: span 4 / span 4;" class="col-[--col-span-default]" wire:key="jRakoYuSPj5dSGZuJxsZ.barangData.tahun.Filament\Forms\Components\TextInput">
                                                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                                    <div class="grid gap-y-2">
                                                                                        <div class="flex items-center justify-between gap-x-3 ">
                                                                                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="barangData.tahun">
                                                                                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                                                    Tahun Pengadaan
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="grid gap-y-2">
                                                                                            <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-text-input overflow-hidden">
                                                                                                <div class="min-w-0 flex-1">
                                                                                                    <p class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition
                                                                                                        duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500
                                                                                                        disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)]
                                                                                                        dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400
                                                                                                        dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)]
                                                                                                        sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" type="text">
                                                                                                        {{$detailBarang['tahun']}}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="--col-span-default: span 2 / span 2;" class="col-[--col-span-default]" wire:key="jRakoYuSPj5dSGZuJxsZ.barangData.nup.Filament\Forms\Components\TextInput">
                                                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                                    <div class="grid gap-y-2">
                                                                                        <div class="flex items-center justify-between gap-x-3 ">
                                                                                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="barangData.nup">
                                                                                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                                                    NUP
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="grid gap-y-2">
                                                                                            <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-text-input overflow-hidden">
                                                                                                <div class="min-w-0 flex-1">
                                                                                                    <p class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition
                                                                                                        duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500
                                                                                                        disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)]
                                                                                                        dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400
                                                                                                        dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)]
                                                                                                        sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" type="text">
                                                                                                        {{$detailBarang['nup']}}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="--col-span-default: span 4 / span 4;" class="col-[--col-span-default]" wire:key="jRakoYuSPj5dSGZuJxsZ.barangData.jumlah.Filament\Forms\Components\TextInput">
                                                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                                    <div class="grid gap-y-2">
                                                                                        <div class="flex items-center justify-between gap-x-3 ">
                                                                                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="barangData.jumlah">
                                                                                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                                                    Jumlah
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="grid gap-y-2">
                                                                                            <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-text-input overflow-hidden">
                                                                                                <div class="min-w-0 flex-1">
                                                                                                    <p class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition
                                                                                                        duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500
                                                                                                        disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)]
                                                                                                        dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400
                                                                                                        dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)]
                                                                                                        sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" type="text">
                                                                                                        {{$detailBarang['jumlah']}}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="--col-span-default: span 4 / span 4;" class="col-[--col-span-default]" wire:key="jRakoYuSPj5dSGZuJxsZ.barangData.kondisi.Filament\Forms\Components\Select">
                                                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                                    <div class="grid gap-y-2">
                                                                                        <div class="flex items-center justify-between gap-x-3 ">
                                                                                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="barangData.kondisi">
                                                                                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                                                    Kondisi Barang
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="grid gap-y-2">
                                                                                            <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-select">
                                                                                                <div class="min-w-0 flex-1">
                                                                                                    <p class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition
                                                                                                        duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500
                                                                                                        disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)]
                                                                                                        dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400
                                                                                                        dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)]
                                                                                                        sm:text-sm sm:leading-6 @if($detailBarang['kondisi']=='Baik')
                                                                                                            bg-green-400
                                                                                                        @elseif ($detailBarang['kondisi']=='Rusak Ringan')
                                                                                                            bg-orange-400
                                                                                                        @elseif ($detailBarang['kondisi']=='Rusak Berat')
                                                                                                            bg-red-500
                                                                                                        @endif ps-3 pe-3" type="text">
                                                                                                        {{$detailBarang['kondisi']}}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="--col-span-default: span 4 / span 4;" class="col-[--col-span-default]" wire:key="jRakoYuSPj5dSGZuJxsZ.barangData.kondisi.Filament\Forms\Components\Select">
                                                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                                    <div class="grid gap-y-2">
                                                                                        <div class="flex items-center justify-between gap-x-3 ">
                                                                                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="barangData.kondisi">
                                                                                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                                                    Ruang
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="grid gap-y-2">
                                                                                            <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-select">
                                                                                                <div class="min-w-0 flex-1">
                                                                                                    <p class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition
                                                                                                        duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500
                                                                                                        disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)]
                                                                                                        dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400
                                                                                                        dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)]
                                                                                                        sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" type="text">
                                                                                                        {{$detailBarang['ruang']}}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="fi-modal-footer w-full px-6 fi-sticky sticky bottom-0 border-t border-gray-200 bg-white py-5 dark:border-white/10 dark:bg-gray-900 mt-auto">
                        <div class="fi-modal-footer-actions gap-3 flex flex-wrap items-center">
                            @if ($detailBarang != null)
                                <button x-data="{
                                            form: null,
                                            isUploadingFile: false,
                                        }"
                                        style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);"
                                        class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition
                                        duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-size-md
                                        fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white
                                        hover:bg-custom-500 dark:bg-custom-500 dark:hover:bg-custom-400 focus-visible:ring-custom-500/50
                                        dark:focus-visible:ring-custom-400/50 fi-ac-btn-action" type="submit" wire:loading.attr="disabled"
                                        wire:click='downloadQr({{$detailBarang['id']}})'>
                                    <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon h-5 w-5"
                                        wire:loading.delay.default="" wire:target="downloadQr({{$detailBarang['id']}})">
                                        <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                                        <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="downloadQr({{$detailBarang['id']}})" class="fi-btn-label">
                                        Download QR
                                    </span>
                                    <span x-show="isUploadingFile" wire:loading.flex wire:target="downloadQr({{$detailBarang['id']}})" style="display: none;">
                                        Downloading...
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
