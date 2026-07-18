<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Filament\Support\BilingualFields;
use BackedEnum;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * The masthead of each inner page. Tabbed by page rather than by language --
 * within a tab, the two languages still sit side by side.
 */
class PagesSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Page headers';

    public static function group(): string
    {
        return 'pages';
    }

    public function formSchema(): array
    {
        $pages = [
            'about'      => 'About',
            'portfolio'  => 'Portfolio',
            'experience' => 'Experience',
            'services'   => 'Services',
            'contact'    => 'Contact',
        ];

        return [
            Tabs::make('Pages')
                ->columnSpanFull()
                ->tabs(array_map(
                    static fn (string $label, string $key): Tab => Tab::make($label)->schema([
                        BilingualFields::text("{$key}_eyebrow", 'Eyebrow', required: false),
                        BilingualFields::text("{$key}_title", 'Title', required: false),
                        BilingualFields::textarea("{$key}_lead", 'Lead', rows: 2),
                    ]),
                    $pages,
                    array_keys($pages),
                )),
        ];
    }
}
