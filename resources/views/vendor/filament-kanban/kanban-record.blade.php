<div
    id="{{ $record->getKey() }}"
    wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
    class="record bg-white dark:bg-gray-700 rounded-lg px-1 py-1 cursor-grab font-medium text-gray-600 dark:text-gray-200"
    @if($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3)
        x-data
        x-init="
            $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
            $el.classList.remove('bg-white', 'dark:bg-gray-700')
            setTimeout(() => {
                $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
                $el.classList.add('bg-white', 'dark:bg-gray-700')
            }, 3000)
        "
    @endif
>
    {{-- {{ $record->{static::$recordTitleAttribute} }} --}}
    <div class="grid w-full bg-dark-secondary px-2 py-2 shadow-md rounded transform border-2 border-dashed border-indigo-600">
        <div class="flex flex-row">
            <div class="flex flex-col">
                <span class="text-sm">{{ $record->perkara_pidum['no_spdp'] }}</span>
                <div class="flex w-full flex-wrap">
                  <div class="flex w-full flex-wrap justify-start p-1 items-center text-xs bg-dark-secondary shadow-inner">
                    <x-filament::badge color="{{ $record->tahapan_perkara['color'] }}">
                        {{ $record->tahapan_perkara['tahap'] }}
                    </x-filament::badge>
                    <x-filament::badge color="info" style="margin-left: .25rem">
                        {{ $record->administrasi_pidum['label'] }}
                    </x-filament::badge>
                    @if ($status['title'] == 'Selesai' OR $status['title'] == 'Proses')
                        <span class="pr-1 text-sm text-custom-600 " style="margin-left: .25rem;--c-400:var(--breaker-400);--c-500:var(--breaker-500);--c-600:var(--breaker-600);">
                            Dikerjakan: {{$record->user->name}}
                        </span>
                    @endif
                  </div>
                </div>
            </div>
            <div class="flex ml-auto self-start">
                @if ($status['title'] == 'Belum' OR $status['title'] == 'Proses')
                    <button style="--c-400:var(--warning-400);--c-500:var(--warning-500);--c-600:var(--warning-600);"
                        class="fi-icon-btn relative flex items-center justify-center rounded-lg outline-none transition duration-75
                        focus-visible:ring-2 -m-1.5 h-8 w-8 fi-color-custom text-custom-500 hover:text-custom-600 focus-visible:ring-custom-600
                        dark:text-custom-400 dark:hover:text-custom-300 dark:focus-visible:ring-custom-500 fi-color-danger fi-ac-action fi-ac-icon-btn-action"
                        title="" type="button" wire:loading.attr="disabled" wire:click="editClicked({{$record->id}})" wire:target="editClicked({{$record->id}})">
                        <svg wire:loading.remove.delay.default="1" wire:target="editClicked({{$record->id}})" class="fi-btn-icon transition duration-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z"></path>
                        </svg>
                        <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-icon-btn-icon h-5 w-5" wire:loading.delay.default="" wire:target="editClicked({{$record->id}})">
                            <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                        </svg>
                    </button>
                    {{-- <x-filament::button icon="heroicon-m-pencil" size="xs"
                        color="warning" style="margin-left: 1px; margin-right: 1px;"
                        wire:click="editClicked('{{ $record->getKey() }}')">
                    </x-filament::button> --}}
                    {{-- {{ ($this->editAction)(['id' => $record->id]) }} --}}
                    {{-- {{ ($this->viewUploadAction)(['record' => $record->id]) }} --}}
                    @if ($status['title'] != 'Proses')
                        {{ ($this->deleteAction)(['record' => $record->id]) }}
                    @endif
                @endif
            </div>
        </div>
        <div class="w-full items-center px-1 py-2" style="line-height: 1;">
            <span class="text-dark-gray font-black pr-1">{{ $record['keterangan'] }}</span>
        </div>
        @if ($record['revisi'] != null OR $status['title'] == 'Revisi')
            @if ($status['title'] != 'Selesai')
                <div class="w-full px-1 py-2 flex flex-col" style="line-height: 0;">
                    <span class="pr-1 text-sm">Revisi:</span>
                    <span class="text-warning-600 pr-1 text-sm">{{ $record['revisi'] }}</span>
                    @if ($record['user_id'] == Auth::user()->id)
                        {{ ($this->revisiAction)(['record' => $record->id]) }}
                    @endif
                </div>
            @endif
        @endif
        <div class="grid w-full py-2 px-2 grid-flow-col-dense grid-cols-2">
          <div class="w-full whitespace-nowrap hidden md:flex flex-wrap text-dark-gray pt-1 col-start-1">
            <span class="text-xs w-full flex items-center text-gray">
                <span class="flex items-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex flex-col ml-2">
                        Deadline:
                        <span class="text-danger-600">
                            {{ Date::parse($record['deadline'])->format('d F Y') }}
                        </span>
                    </div>
                </span>
            </span>
          </div>
          {{-- <div class="flex ml-auto self-start justify-end col-start-2">
            <img class="inline-block relative rounded-full text-cool-gray-50 dark:text-gray-600 h-6 w-6" src="https://assets.codepen.io/1149983/avatar-23.png" alt="avatar" />
          </div> --}}
        </div>
        @if ($status['title'] != 'Belum')
            @if ($record['file_path'] != null)
                <div class="flex w-full flex-wrap justify-between">
                    {{ ($this->viewUploadAction)(['record' => $record->id]) }}
                    {{ ($this->deleteUploadAction)(['record' => $record->id]) }}
                </div>
            @else
                {{ ($this->uploadAction)(['record' => $record->id]) }}
            @endif
        @endif
    </div>
</div>
