<?php

namespace App\Filament\Resources\Habits;

use App\Filament\Resources\Habits\Pages\CreateHabit;
use App\Filament\Resources\Habits\Pages\EditHabit;
use App\Filament\Resources\Habits\Pages\ListHabits;
use App\Filament\Resources\Habits\Pages\ViewHabit;
use App\Filament\Resources\Habits\Schemas\HabitForm;
use App\Filament\Resources\Habits\Schemas\HabitInfolist;
use App\Filament\Resources\Habits\Tables\HabitsTable;
use App\Models\Habit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class HabitResource extends Resource
{
    protected static ?string $model = Habit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return HabitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HabitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HabitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHabits::route('/'),
            'create' => CreateHabit::route('/create'),
            'view' => ViewHabit::route('/{record}'),
            'edit' => EditHabit::route('/{record}/edit'),
        ];
    }
}
