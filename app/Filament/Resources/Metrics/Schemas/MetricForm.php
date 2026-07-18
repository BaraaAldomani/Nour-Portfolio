<?php

declare(strict_types=1);

namespace App\Filament\Resources\Metrics\Schemas;

use App\Filament\Support\BilingualFields;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Figure')
                    ->description('Shown on the home page as a count-up. Keep these defensible.')
                    ->columns(3)
                    ->schema([
                        BilingualFields::key(),

                        TextInput::make('value')
                            ->label('Value')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100000),

                        TextInput::make('suffix')
                            ->label('Suffix')
                            ->maxLength(8)
                            ->placeholder('+')
                            ->helperText('Optional, e.g. “+”.'),
                    ]),

                BilingualFields::text('label', 'Label'),
            ]);
    }
}
