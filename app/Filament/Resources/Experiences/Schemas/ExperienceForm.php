<?php

declare(strict_types=1);

namespace App\Filament\Resources\Experiences\Schemas;

use App\Filament\Support\BilingualFields;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dates')
                    ->columns(3)
                    ->schema([
                        BilingualFields::key(),

                        DatePicker::make('start_date')
                            ->label('Start date')
                            ->required()
                            ->native(false)
                            ->displayFormat('M Y'),

                        DatePicker::make('end_date')
                            ->label('End date')
                            ->native(false)
                            ->displayFormat('M Y')
                            // A current role has no end date; the toggle below
                            // is what the timeline actually reads.
                            ->hidden(fn ($get): bool => (bool) $get('is_current'))
                            ->after('start_date'),

                        Toggle::make('is_current')
                            ->label('Current role')
                            ->live()
                            ->helperText('Renders as “Present” on the timeline.'),
                    ]),

                BilingualFields::text('company', 'Company'),
                BilingualFields::text('role', 'Role'),
                BilingualFields::text('location', 'Location', required: false),
                BilingualFields::textarea('summary', 'Summary', rows: 2),
                BilingualFields::list('highlights', 'Responsibilities', 'One per entry. Press Enter after each.'),
            ]);
    }
}
