<?php

declare(strict_types=1);

namespace App\Filament\Resources\Dishes\Schemas;

use App\Filament\Support\BilingualFields;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DishForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Photograph')
                    ->columns(2)
                    ->schema([
                        BilingualFields::key(),

                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->imageEditor()
                            ->directory('dishes')
                            ->disk('public')
                            ->maxSize(8192)
                            ->required()
                            ->helperText('Seeded dishes point at public/images/dishes. Uploading here replaces that.'),

                        Toggle::make('is_featured')
                            ->label('Show on the home page')
                            ->helperText('The home page shows the first six featured dishes.'),
                    ]),

                BilingualFields::text('title', 'Title'),
                BilingualFields::text('category', 'Category')
                    ->description('Dishes are grouped and filtered by this exact text, so keep it consistent.'),
                BilingualFields::textarea('description', 'Description', rows: 3),
            ]);
    }
}
