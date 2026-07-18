<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Filament\Support\BilingualFields;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ContactSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 7;

    protected static ?string $title = 'Contact details';

    public static function group(): string
    {
        return 'contact';
    }

    public function formSchema(): array
    {
        return [
            Section::make('Channels')
                ->columns(3)
                ->schema([
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(190),

                    TextInput::make('phone')
                        ->label('Phone')
                        ->tel()
                        ->maxLength(32)
                        ->helperText('International format, e.g. +966504325762'),

                    TextInput::make('whatsapp')
                        ->label('WhatsApp')
                        ->maxLength(32)
                        ->helperText('Digits only, no “+”.'),
                ]),

            BilingualFields::text('city', 'City', required: false),
            BilingualFields::text('availability', 'Availability badge', required: false),
            BilingualFields::text('form_title', 'Form heading', required: false),
            BilingualFields::textarea('form_note', 'Form note', rows: 2),
            BilingualFields::textarea('success', 'Success message', rows: 2),
        ];
    }
}
