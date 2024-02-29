<div class="flex flex-col task-row">
    @error('newPhoto') <div class="w-full my-3 text-red-500"><span class="error">{{ $message }}</span></div> @enderror

    @if ($newPhoto)
        <div class="flex justify-between mb-2">
            <span class="text-white text-lg font-bold">Photo Preview</span>

            <button type="button" wire:click.prevent="unsetPhoto" class="w-10 text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-3 py-2 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        </div>

        @if (!empty($newPhoto->photo))
            <img src="{{ Storage::disk('s3')->url($newPhoto->photo) }}" class="max-h-max max-w-full rounded-lg mb-3">
        @else
            <img src="{{ $newPhoto->temporaryUrl() }}" class="max-h-max max-w-full rounded-lg mb-3">
        @endif
    @endif

    <div class="w-full flex mb-3">
        {{-- photo --}}
        <input wire:model.live="newPhoto" type="file" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />

        <div class="w-48 text-right pl-2">
            <button wire:click.prevent="create" type="button" class="w-half text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Upload Photo</button>
        </div>
    </div>

    <div class="block text-white" wire:loading wire:target="newPhoto">Uploading...</div>
</div>