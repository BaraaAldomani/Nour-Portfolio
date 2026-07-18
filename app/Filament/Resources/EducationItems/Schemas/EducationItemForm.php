<?php

declare(strict_types=1);

namespace App\Filament\Resources\EducationItems\Schemas;

use App\Filament\Support\BilingualFields;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EducationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Record')
                    ->columns(2)
                    ->schema([
                        BilingualFields::key(),

                        DatePicker::make('completed_on')
                            ->label('Completed')
                            ->native(false)
                            ->displayFormat('M Y'),
                    ]),

                BilingualFields::text('institution', 'Institution'),
                BilingualFields::text('credential', 'Credential'),
                BilingualFields::text('field', 'Field of study', required: false),
                BilingualFields::text('grade', 'Grade', required: false),
            ]);
    }
}
