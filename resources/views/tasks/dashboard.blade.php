<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                
                <div class="flex flex-column">
                    <div class="w-half flex-grow">
                        <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Latest Customers</h5>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                                    View all
                                </a>
                            </div>

                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full" src="https://placekitten.com/200/300" alt="Neil image">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                Neil Sims
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                email@windster.com
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            $320
                                        </div>
                                    </div>
                                </li>
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full" src="https://placekitten.com/200/300" alt="Bonnie image">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                Bonnie Green
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                email@windster.com
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            $3467
                                        </div>
                                    </div>
                                </li>
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full" src="https://placekitten.com/200/300" alt="Michael image">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                Michael Gough
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                email@windster.com
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            $67
                                        </div>
                                    </div>
                                </li>
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full" src="https://placekitten.com/200/300" alt="Lana image">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                Lana Byrd
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                email@windster.com
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            $367
                                        </div>
                                    </div>
                                </li>
                                <li class="pt-3 pb-0 sm:pt-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full" src="https://placekitten.com/200/300" alt="Thomas image">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                Thomes Lean
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                email@windster.com
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            $2367
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="w-half">
                        <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ $today }}</h5>
                            </div>

                            @foreach($tasks[$today . ' 00:00:00'] as $task)
                                <livewire:show-tasks :task="$task" />
                            @endforeach

                            <livewire:create-task :date="$today" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
