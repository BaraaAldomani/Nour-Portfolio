<?php

declare(strict_types=1);

namespace App\Filament\Resources\EducationItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EducationItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('credential_en')
                    ->label('Credential')
                    ->description(fn ($record): string => $record->credential_ar)
                    ->searchable(['credential_en', 'credential_ar']),

                TextColumn::make('field_en')
                    ->label('Field'),

                TextColumn::make('institution_en')
                    ->label('Institution')
                    ->limit(40),

                TextColumn::make('completed_on')
                    ->label('Completed')
                    ->date('m/Y')
                    ->sortable(),
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
