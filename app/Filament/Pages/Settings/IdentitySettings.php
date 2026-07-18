<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Filament\Support\BilingualFields;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class IdentitySettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Identity';

    public static function group(): string
    {
        return 'identity';
    }

    public function formSchema(): array
    {
        return [
            BilingualFields::text('name', 'Name'),
            BilingualFields::text('role', 'Role'),
            BilingualFields::text('tagline', 'Tagline'),
            BilingualFields::text('location', 'Location'),

            Section::make('Mark')
                ->schema([
                    TextInput::make('initials')
                        ->label('Monogram letter')
                        ->maxLength(2)
                        ->helperText('Used by the logo mark.'),
                ]),
        ];
    }
}
