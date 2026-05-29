<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('All Tasks') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                &larr; Back to dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                    @forelse ($weeks as $week)
                        <div class="mb-10">
                            <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-5">
                                {{ $week['label'] }}
                            </h3>

                            @foreach ($week['days'] as $dayKey => $buckets)
                                <div class="mb-6">
                                    <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">
                                        {{ \Carbon\Carbon::parse($dayKey)->format('l, M j') }}
                                    </h4>

                                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach (($buckets['tasks'] ?? []) as $task)
                                            <li class="flex items-center justify-between py-1.5 text-sm">
                                                <span class="text-gray-900 dark:text-gray-200 {{ $task->is_done ? 'line-through text-gray-400 dark:text-gray-500' : '' }}">
                                                    {{ $task->label }}
                                                </span>
                                                <span class="text-gray-500 dark:text-gray-400">{{ $task->hours }}h</span>
                                            </li>
                                        @endforeach

                                        @foreach (($buckets['extras'] ?? []) as $extra)
                                            <li class="flex items-center justify-between py-1.5 text-sm italic">
                                                <span class="text-gray-700 dark:text-gray-300 {{ $extra->is_done ? 'line-through text-gray-400 dark:text-gray-500' : '' }}">
                                                    {{ $extra->label }}
                                                </span>
                                                <span class="text-gray-500 dark:text-gray-400">{{ $extra->hours }}h</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No tasks yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
