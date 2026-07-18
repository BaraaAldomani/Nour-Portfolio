<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Filament\Support\BilingualFields;
use BackedEnum;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class HomeSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 4;

    protected static ?string $title = 'Home page';

    public static function group(): string
    {
        return 'home';
    }

    public function formSchema(): array
    {
        return [
            Tabs::make('Home')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Hero')->schema([
                        BilingualFields::text('hero_eyebrow', 'Eyebrow', required: false),
                        BilingualFields::textarea('hero_lead', 'Lead paragraph', rows: 3),
                        BilingualFields::text('hero_cta', 'Primary button', required: false),
                        BilingualFields::text('hero_cta_alt', 'Secondary button', required: false),
                    ]),

                    Tab::make('Principle')->schema([
                        BilingualFields::text('intro_eyebrow', 'Eyebrow', required: false),
                        BilingualFields::text('intro_title', 'Title', required: false),
                        BilingualFields::textarea('intro_body', 'Body', rows: 4),
                    ]),

                    Tab::make('Sections')->schema([
                        BilingualFields::text('portfolio_eyebrow', 'Portfolio eyebrow', required: false),
                        BilingualFields::text('portfolio_title', 'Portfolio title', required: false),
                        BilingualFields::text('portfolio_cta', 'Portfolio link', required: false),
                        BilingualFields::text('services_eyebrow', 'Services eyebrow', required: false),
                        BilingualFields::text('services_title', 'Services title', required: false),
                        BilingualFields::text('process_eyebrow', 'Method eyebrow', required: false),
                        BilingualFields::text('process_title', 'Method title', required: false),
                        BilingualFields::text('experience_eyebrow', 'Experience eyebrow', required: false),
                        BilingualFields::text('experience_title', 'Experience title', required: false),
                        BilingualFields::text('experience_cta', 'Experience link', required: false),
                    ]),

                    Tab::make('Closing call to action')->schema([
                        BilingualFields::text('cta_title', 'Title', required: false),
                        BilingualFields::textarea('cta_body', 'Body', rows: 2),
                        BilingualFields::text('cta_button', 'Button', required: false),
                    ]),
                ]),
        ];
    }
}
