<?php

declare(strict_types=1);

namespace App\Filament\Resources\Metrics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MetricsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('value')
                    ->label('Value')
                    ->formatStateUsing(fn ($state, $record): string => $state.($record->suffix ?? '')),

                TextColumn::make('label_en')
                    ->label('Label')
                    ->description(fn ($record): string => $record->label_ar)
                    ->searchable(['label_en', 'label_ar']),
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
