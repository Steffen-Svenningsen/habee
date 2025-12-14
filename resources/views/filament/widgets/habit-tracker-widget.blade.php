<x-filament-widgets::widget>
        @if ($this->getHabits()->isEmpty())
            <div class="text-gray-400">
                You have no habits tracked yet. <a class="border-b duration-150 hover:text-gray-100" href="{{ route('filament.app.resources.habits.create') }}">Create one</a> to get started!
            </div>
        @endif
        <div class="grid md:grid-cols-2 gap-4">
            @foreach ($this->getHabits() as $habit)
                @php
                    $completedToday = (bool) optional(
                        $habit->completions->first(fn ($c) => $c->date->isToday())
                    )->is_completed;
                @endphp

                <button
                    wire:click="toggleHabit({{ $habit->id }})"
                    class="p-4 rounded-xl transition relative"
                    style="
                        @if ($completedToday)
                            background-image: linear-gradient( to top right, {{ $habit->category->color }}cc, {{ $habit->category->color }}10 );
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

                    <div class="flex gap-2 mt-8 justify-between">
                        @foreach ($this->getWeekDates() as $date)
                            @php
                                $completion = $habit->completions->first(
                                    fn ($c) => $c->date->isSameDay($date)
                                );

                                $completed = (bool) ($completion?->is_completed ?? false);
                            @endphp

                            <div class="flex flex-col items-center gap-1 relative">
                                <span class="text-[10px] opacity-80">
                                    {{ $date->format('D') }}
                                </span>

                                <div
                                    class="border w-7 h-7 flex items-center justify-center text-[10px] font-bold rounded-full"
                                    style="{{ $completed ? 'background-color: ' . $habit->category->color : '' }}">
                                    {{$date->format('j')}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a wire:click.stop href="{{ route('filament.app.resources.habits.edit', $habit) }}">
                        <div class="absolute z-10 p-2 top-4 right-2 opacity-50 hover:opacity-100 transition">
                            <x-heroicon-o-pencil-square class="w-6 h-6" />
                        </div>
                    </a>
                </button>
            @endforeach
        </div>
</x-filament-widgets::widget>
