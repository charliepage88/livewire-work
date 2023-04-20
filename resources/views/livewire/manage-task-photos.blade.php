<div>
    <div x-data="{ is_deleting: @entangle('is_deleting') }" class="grid grid-cols-2 md:grid-cols-2 gap-2">
        @foreach($photos as $index => $row)
            <div x-data="{ photo: @js($row) }" class="flex flex-col task-row" data-id="{{ $row['id'] }}">
                <div class="w-full flex mb-3 relative">
                    {{-- photo --}}
                    <img src="{{ Storage::disk('s3')->url(is_array($row) ? $row['photo'] : $row->photo) }}" class="max-h-48 max-w-full rounded-lg">

                    {{-- action items --}}
                    <div class="w-12 absolute top-2 left-0 text-right pl-2" x-data="{ 'viewImageModal': false }">
                        <button type="button" wire:click.prevent="deletePhoto({{ $row['id'] }})" class="w-10 text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-3 py-2 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>

                        <!-- Trigger for View Image Modal -->
                        <button type="button" @click.prevent="viewImageModal = true" class="w-10 mt-1 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-3 py-2 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </button>

                        <!-- View Image Modal -->
                        <div
                            class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                            x-show="viewImageModal"
                            @keydown.escape="viewImageModal = false"
                        >
                            <!-- Modal inner -->
                            <div
                                class="w-10/12 px-6 py-4 mx-auto text-left bg-white rounded shadow-lg"
                                @click.away="viewImageModal = false"
                                x-transition:enter="motion-safe:ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                            >
                                <div class="flex justify-between border-b border-slate-300 mb-2 pb-2">
                                    <h5 class="text-3xl mr-3 text-black">Preview Image</h5>

                                    <div class="w-auto hover:cursor-pointer" @click.prevent="viewImageModal = false">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex">
                                    <img src="{{ Storage::disk('s3')->url(is_array($row) ? $row['photo'] : $row->photo) }}" class="mx-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- action buttons --}}
                <div x-show="is_deleting === photo.id" class="w-auto text-center mb-6">
                    <button wire:click.prevent="deletePhoto({{ $row['id'] }})" type="button" class="w-half text-white bg-gradient-to-r from-gray-500 via-gray-600 to-gray-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-gray-300 dark:focus:ring-gray-800 shadow-lg shadow-gray-500/50 dark:shadow-lg dark:shadow-gray-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cancel</button>
                    <button wire:click.prevent="delete" type="button" class="w-half text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center">DELETE</button>
                </div>
            </div>
        @endforeach
    </div>

    @includeWhen($canCreate, 'livewire/components/create-photo')
</div>
