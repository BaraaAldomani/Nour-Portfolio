<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProcessSteps\Schemas;

use App\Filament\Support\BilingualFields;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProcessStepForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Step')
                    ->description('Numbered automatically from the table order.')
                    ->schema([
                        BilingualFields::key(),
                    ]),

                BilingualFields::text('title', 'Title'),
                BilingualFields::textarea('description', 'Description', required: true, rows: 3),
            ]);
    }
}
