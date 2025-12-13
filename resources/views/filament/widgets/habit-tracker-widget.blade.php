<x-filament-widgets::widget>
    <x-filament::section>
        @if ($this->getHabits()->isEmpty())
            <div class="text-center text-gray-400">
                You have no habits tracked yet. <a class="border-b duration-150 hover:text-gray-100" href="{{ route('filament.app.resources.habits.create') }}">Create one</a> to get started!
            </div>
        @endif
        <div class="grid md:grid-cols-2 gap-4">
            @foreach ($this->getHabits() as $habit)
                @php
                    $completedToday = $habit->completions->isNotEmpty();
                @endphp

                <button
                    wire:click="toggleHabit({{ $habit->id }})"
                    class="p-4 rounded-xl transition relative"
                    style="
                        @if ($completedToday)
                            background-image: linear-gradient( to top right, {{ $habit->category->color }}, {{ $habit->category->color }}10 );
                        @else
                            background-image: linear-gradient( to top right, {{ $habit->category->color }}20, {{ $habit->category->color }}10 );
                        @endif
                    "
                >
                    <div class="font-semibold flex gap-4 items-center">
                        <div
                            class="p-2 rounded-xl inline-flex items-center justify-center"
                            style="background-color: {{ $habit->category->color }}"
                        >
                            <img
                                class="w-6 h-6"
                                src="{{ asset('storage/' . $habit->category->icon) }}"
                                alt=""
                            >
                        </div>

                        {{ $habit->name }}
                    </div>

                    <a href="{{ route('filament.app.resources.habits.edit', $habit) }}">
                        <div class="absolute top-4 right-4 opacity-50 hover:opacity-100 transition">
                            <x-heroicon-o-pencil-square class="w-6 h-6" />
                        </div>
                    </a>
                </button>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
