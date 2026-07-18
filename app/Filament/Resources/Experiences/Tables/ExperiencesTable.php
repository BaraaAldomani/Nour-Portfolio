<?php

declare(strict_types=1);

namespace App\Filament\Resources\Experiences\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('company_en')
                    ->label('Company')
                    ->description(fn ($record): string => $record->company_ar)
                    ->searchable(['company_en', 'company_ar']),

                TextColumn::make('role_en')
                    ->label('Role'),

                TextColumn::make('start_date')
                    ->label('From')
                    ->date('m/Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('To')
                    ->date('m/Y')
                    ->placeholder('Present'),

                IconColumn::make('is_current')
                    ->label('Current')
                    ->boolean(),
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
