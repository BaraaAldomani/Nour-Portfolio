<?php

declare(strict_types=1);

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Support\BilingualFields;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identity')
                    ->columns(2)
                    ->schema([
                        BilingualFields::key(),

                        Select::make('icon')
                            ->label('Icon')
                            ->required()
                            // Matches the hand-drawn set in components/service-icon.blade.php.
                            ->options([
                                'menu'    => 'Menu / clipboard',
                                'brigade' => 'Brigade / team',
                                'flame'   => 'Flame / hot kitchen',
                                'leaf'    => 'Leaf / cold kitchen',
                                'shield'  => 'Shield / food safety',
                                'scale'   => 'Scale / cost control',
                                'knife'   => 'Knife',
                            ]),
                    ]),

                BilingualFields::text('title', 'Title'),
                BilingualFields::textarea('summary', 'Summary', required: true, rows: 2)
                    ->description('One sentence. Shown on the home page and the services index.'),
                BilingualFields::textarea('description', 'Description', rows: 4),
                BilingualFields::list('features', 'Features', 'Press Enter after each item.'),
            ]);
    }
}
