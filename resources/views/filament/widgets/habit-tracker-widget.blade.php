<x-filament-widgets::widget>
    <x-filament::section>
        @if ($this->getHabits()->isEmpty())
            <div class="text-center text-gray-500">
                You have no habits tracked yet.
            </div>
        @endif
        <div class="grid grid-cols-2 gap-4">
            @foreach ($this->getHabits() as $habit)
                @php
                    $completedToday = $habit->completions->isNotEmpty();
                @endphp

                <button
                    wire:click="toggleHabit({{ $habit->id }})"
                    class="
                        p-4 rounded-xl border
                        transition
                        {{ $completedToday
                            ? 'bg-primary-500 text-white'
                            : 'bg-gray-100 text-gray-500'
                        }}
                    "
                >
                    <div class="font-semibold">
                        {{ $habit->name }}
                    </div>

                    <div class="text-sm opacity-70">
                        {{ $completedToday ? 'Done today' : 'Not done' }}
                    </div>
                </button>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
