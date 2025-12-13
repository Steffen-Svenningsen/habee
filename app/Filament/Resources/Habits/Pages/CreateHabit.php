<?php

namespace App\Filament\Resources\Habits\Pages;

use App\Filament\Resources\Habits\HabitResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHabit extends CreateRecord
{
    protected static string $resource = HabitResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }
}
