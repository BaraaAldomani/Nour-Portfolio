<?php

declare(strict_types=1);

namespace App\Filament\Resources\Skills\Schemas;

use App\Enums\SkillCategory;
use App\Filament\Support\BilingualFields;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Classification')
                    ->columns(3)
                    ->schema([
                        BilingualFields::key(),

                        Select::make('category')
                            ->label('Category')
                            ->required()
                            ->options(SkillCategory::class)
                            ->helperText('Skills are grouped by category on the about page.'),

                        Select::make('level')
                            ->label('Level')
                            ->required()
                            ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'])
                            ->default(4)
                            ->helperText('Drawn as a five-segment meter.'),
                    ]),

                BilingualFields::text('name', 'Name'),
            ]);
    }
}
