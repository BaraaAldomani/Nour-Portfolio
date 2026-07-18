<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Filament\Support\BilingualFields;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class PortfolioSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 6;

    protected static ?string $title = 'Portfolio page';

    public static function group(): string
    {
        return 'portfolio';
    }

    public function formSchema(): array
    {
        return [
            BilingualFields::textarea('note', 'Footnote', rows: 2)
                ->description('Shown beneath the grid.'),

            Section::make('External gallery')
                ->columns(1)
                ->schema([
                    TextInput::make('pinterest_url')
                        ->label('Link URL')
                        ->url()
                        ->maxLength(255),
                ]),

            BilingualFields::text('pinterest_label', 'Link label', required: false),
        ];
    }
}
