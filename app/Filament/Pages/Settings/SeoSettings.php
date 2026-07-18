<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Filament\Support\BilingualFields;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class SeoSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 8;

    protected static ?string $title = 'SEO';

    public static function group(): string
    {
        return 'seo';
    }

    public function formSchema(): array
    {
        return [
            BilingualFields::text('title', 'Site title', required: false)
                ->description('Used verbatim on the home page; inner pages append the name.'),

            BilingualFields::textarea('description', 'Meta description', rows: 3)
                ->description('Aim for 150–160 characters.'),

            BilingualFields::textarea('keywords', 'Keywords', rows: 2),

            Section::make('Profiles')
                ->schema([
                    Textarea::make('same_as')
                        ->label('Profile URLs')
                        ->rows(3)
                        ->helperText('One per line. Emitted as schema.org sameAs.'),
                ]),
        ];
    }
}
