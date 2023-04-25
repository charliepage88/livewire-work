<div class="flex flex-col task-row">
    @error('note.body') <div class="w-full my-3 text-red-500"><span class="error">{{ $message }}</span></div> @enderror

    <div class="w-full flex mb-3">
        {{-- body --}}
        <textarea wire:model.lazy="note.body" type="text" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>

        <div class="w-48 text-right pl-2">
            <button wire:click.prevent="create" type="submit" class="w-half text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create Note</button>
        </div>
    </div>
</div>