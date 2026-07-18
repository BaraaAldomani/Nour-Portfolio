<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ImageSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 9;

    protected static ?string $title = 'Images';

    public static function group(): string
    {
        return 'images';
    }

    public function formSchema(): array
    {
        return [
            Section::make('Site imagery')
                ->description('Leave empty to keep the image shipped with the site.')
                ->columns(2)
                ->schema([
                    FileUpload::make('portrait')
                        ->label('Portrait')
                        ->image()
                        ->directory('site')
                        ->disk('public')
                        ->maxSize(8192)
                        ->helperText('A cut-out with a transparent background works best.'),

                    FileUpload::make('og')
                        ->label('Social sharing image')
                        ->image()
                        ->directory('site')
                        ->disk('public')
                        ->maxSize(8192)
                        ->helperText('Shown when the site is shared. 1200×630 is ideal.'),
                ]),
        ];
    }
}
