<div>
    <form wire:submit.prevent="create" class="flex flex-col">
        @error('task.label') <div class="w-full my-2 text-red-500"><span class="error">{{ $message }}</span></div> @enderror
        @error('task.hours') <div class="w-full my-2 text-red-500"><span class="error">{{ $message }}</span></div> @enderror

        <div class="w-full flex mb-6">
            {{-- is_done --}}
            <div class="flex items-start mr-6">
                <div class="flex items-center h-8">
                    <input wire:model="task.is_done" type="checkbox" class="w-8 h-8 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
                </div>
            </div>

            {{-- label --}}
            <input wire:model.lazy="task.label" type="text" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light mr-6 pr-6" required>

            {{-- hours --}}
            <div class="relative font-white mr-6">
                {{-- <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div> --}}
                <input wire:model.lazy="task.hours" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-12 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            {{-- is_time_in --}}
            <div class="flex items-start">
                <div class="flex items-center h-8">
                    <input wire:model="task.is_time_in" type="checkbox" class="w-8 h-8 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Create Task
        </button>
    </form>
</div>
