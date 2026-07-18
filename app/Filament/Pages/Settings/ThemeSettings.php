<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use BackedEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * The three brand colours. Everything else on the public site is derived from
 * these with color-mix(), so changing one here re-themes the whole site on the
 * next request.
 */
class ThemeSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSwatch;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Theme';

    public static function group(): string
    {
        return 'theme';
    }

    public function formSchema(): array
    {
        return [
            Section::make('Brand colours')
                ->description('These three drive every colour on the site. Keep the secondary dark and the accent light, or contrast will suffer.')
                ->columns(3)
                ->schema([
                    ColorPicker::make('brand_primary')
                        ->label('Primary')
                        ->required()
                        ->hex()
                        ->helperText('Gold. Links, buttons, the plate ring.'),

                    ColorPicker::make('brand_secondary')
                        ->label('Secondary')
                        ->required()
                        ->hex()
                        ->helperText('Near-black. Page background and ink.'),

                    ColorPicker::make('brand_accent')
                        ->label('Accent')
                        ->required()
                        ->hex()
                        ->helperText('Cream. Body text on dark, light sections.'),
                ]),
        ];
    }
}
