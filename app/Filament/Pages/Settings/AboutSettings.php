<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Filament\Support\BilingualFields;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AboutSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'About page';

    public static function group(): string
    {
        return 'about';
    }

    public function formSchema(): array
    {
        return [
            BilingualFields::text('story_title', 'Story title', required: false),
            BilingualFields::textarea('story_body', 'Story', rows: 8)
                ->description('Leave a blank line between paragraphs.'),

            BilingualFields::text('philosophy_title', 'Philosophy title', required: false),
            BilingualFields::textarea('philosophy_body', 'Philosophy', rows: 5),

            BilingualFields::text('skills_title', 'Skills heading', required: false),
            BilingualFields::text('education_title', 'Education heading', required: false),
            BilingualFields::text('languages_title', 'Languages heading', required: false),
            BilingualFields::textarea('languages_body', 'Languages', rows: 2),
        ];
    }
}
