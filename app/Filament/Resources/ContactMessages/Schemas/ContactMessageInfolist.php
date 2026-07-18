<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sender')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')->label('Name'),

                        TextEntry::make('email')
                            ->label('Email')
                            ->copyable()
                            ->url(fn ($record): string => "mailto:{$record->email}"),

                        TextEntry::make('created_at')
                            ->label('Received')
                            ->dateTime('d M Y, H:i'),
                    ]),

                Section::make('Message')
                    ->schema([
                        TextEntry::make('message')
                            ->label('')
                            ->prose()
                            ->columnSpanFull(),
                    ]),

                Section::make('Context')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('locale')
                            ->label('Sent from')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'ar' => 'Arabic site',
                                'en' => 'English site',
                                default => $state,
                            }),

                        TextEntry::make('ip')
                            ->label('IP address')
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
