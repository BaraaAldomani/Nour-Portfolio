<?php

declare(strict_types=1);

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('title_en')
                    ->label('Title')
                    ->description(fn ($record): string => $record->title_ar)
                    ->searchable(['title_en', 'title_ar']),

                TextColumn::make('icon')
                    ->label('Icon')
                    ->badge(),

                TextColumn::make('summary_en')
                    ->label('Summary')
                    ->limit(60)
                    ->toggleable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
