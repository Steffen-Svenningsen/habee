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
                $q->where('date', today());
            }])
            ->get();
    }

    public function toggleHabit(int $habitId)
    {
        $habit = Habit::findOrFail($habitId);

        $completion = $habit->completions()
            ->where('date', today())
            ->first();

        if ($completion) {
            $completion->delete();
        } else {
            $habit->completions()->create([
                'date' => today(),
            ]);

            Notification::make()
                ->title('Nice work! 💪')
                ->body("You've completed the habit: {$habit->name} for today.")
                ->success()
                ->send();
        }
    }
}
