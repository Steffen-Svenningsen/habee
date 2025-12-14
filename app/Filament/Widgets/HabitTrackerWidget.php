<?php

namespace App\Filament\Widgets;

use App\Models\Habit;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class HabitTrackerWidget extends Widget
{
    protected string $view = 'filament.widgets.habit-tracker-widget';

    protected int|string|array $columnSpan = 'full';

    public function getHabits()
    {
        return Habit::where('user_id', Auth::id())
            ->with(['completions' => function ($q) {
                $q->whereBetween('date', [
                    today()->subDays(6),
                    today(),
                ]);
            }])
            ->get();
    }

    public function getWeekDates(): array
    {
        return collect(range(0, 6))
            ->map(fn ($daysAgo) => today()->subDays($daysAgo))
            ->values()
            ->reverse()
            ->toArray();
    }

    public function toggleHabit(int $habitId)
    {
        $habit = Habit::findOrFail($habitId);

        $completion = $habit->completions()
            ->where('date', today())
            ->first();

        if ($completion) {
            $completion->update([
                'is_completed' => ! $completion->is_completed,
            ]);
        } else {
            $habit->completions()->create([
                'date' => today(),
                'is_completed' => true,
            ]);
        }

        if ($completion && ! $completion->is_completed) {
            Notification::make()
                ->id('habit-completion-toggle')
                ->title("Marked '{$habit->name}' as incomplete for today ⏳")
                ->danger()
                ->send();
        } else {
            Notification::make()
                ->id('habit-completion-toggle')
                ->title("Marked '{$habit->name}' as complete for today 💪")
                ->success()
                ->send();
        }
    }
}
