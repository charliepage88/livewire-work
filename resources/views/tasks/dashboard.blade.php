<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                @if (session()->has('message'))
                    <div id="notification" class="flex items-center w-full max-w-xs p-6 space-x-8 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800 mb-4 text-lg" role="alert">
                        <svg aria-hidden="true" class="w-8 h-8 text-blue-600 dark:text-blue-500" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M511.6 36.86l-64 415.1c-1.5 9.734-7.375 18.22-15.97 23.05c-4.844 2.719-10.27 4.097-15.68 4.097c-4.188 0-8.319-.8154-12.29-2.472l-122.6-51.1l-50.86 76.29C226.3 508.5 219.8 512 212.8 512C201.3 512 192 502.7 192 491.2v-96.18c0-7.115 2.372-14.03 6.742-19.64L416 96l-293.7 264.3L19.69 317.5C8.438 312.8 .8125 302.2 .0625 289.1s5.469-23.72 16.06-29.77l448-255.1c10.69-6.109 23.88-5.547 34 1.406S513.5 24.72 511.6 36.86z"></path></svg>
                        <div class="pl-4 text-sm font-normal">{{ session('message') }}</div>
                    </div>
                @endif
                
                <div class="flex flex-column">
                    <div class="w-half">
                        <div class="w-full max-w-xl p-2 bg-white border border-gray-200 rounded-lg shadow sm:p-4 dark:bg-gray-800 dark:border-gray-700">
                            {{-- <div class="flex items-center justify-between mb-6">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Past Tasks</h5>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                                    View all
                                </a>
                            </div> --}}

                            @foreach($tasks as $date => $taskRows)
                                @if ($date !== $todayFull)
                                    <div class="flex items-center justify-between my-6">
                                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ str_replace(' 00:00:00', '', $date) }}</h5>

                                        <livewire:show-task-hours-total :date="$date" :tasks="$taskRows" :extraTasks="$extraTasks" :wire:key="'task-hours-' . $date" />
                                    </div>

                                    <livewire:manage-tasks :canCreate="false" :date="$date" :tasks="$taskRows" :wire:key="'tasks-' . $date" />

                                    @if (Arr::has($extraTasks, $date))
                                        <hr class="my-5" />

                                        <livewire:manage-tasks-extra :canCreate="false" :date="$date" :tasks="$extraTasks[$date]" :wire:key="'tasks-extra-' . $date" />
                                    @endif

                                    <hr class="my-5" />

                                    <livewire:manage-notes :canCreate="false" :date="$date" :notes="Arr::has($notesByDate, $date) ? $notesByDate[$date] : []" />

                                    <div class="mt-2">
                                        <livewire:manage-task-photos :canCreate="false" :grouped_date="$date" :photos="Arr::has($photosByDate, $date) ? $photosByDate[$date] : []" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="w-half ml-6 flex-grow">
                        <div class="w-full p-2 bg-white border border-gray-200 rounded-lg shadow sm:p-4 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex items-center justify-between my-6">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ $today }}</h5>
                                @if (Arr::has($tasks, $todayFull))
                                    <livewire:show-task-hours-total :date="$todayFull" :tasks="$tasks[$todayFull]" :extraTasks="$extraTasks" />
                                @endif
                            </div>

                            <div id="tasksToday" x-ref="tasksToday">
                                <livewire:manage-tasks :date="$todayFull" :tasks="Arr::has($tasks, $todayFull) ? $tasks[$todayFull] : []" :wire:key="'tasks-today'" />
                            </div>

                            <hr class="my-5" />

                            <livewire:manage-tasks-extra :date="$todayFull" :tasks="Arr::has($extraTasks, $todayFull) ? $extraTasks[$todayFull] : []" :wire:key="'tasks-extra-today'" />

                            <div class="mt-6">
                                <livewire:manage-notes :date="$todayFull" :notes="Arr::has($notesByDate, $todayFull) ? $notesByDate[$todayFull] : []" />
                            </div>

                            <div class="mt-2">
                                <livewire:manage-task-photos :grouped_date="$todayFull" :photos="Arr::has($photosByDate, $todayFull) ? $photosByDate[$todayFull] : []" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
