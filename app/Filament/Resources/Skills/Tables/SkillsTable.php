<?php

declare(strict_types=1);

namespace App\Filament\Resources\Skills\Tables;

use App\Enums\SkillCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SkillsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('name_en')
                    ->label('Name')
                    ->description(fn ($record): string => $record->name_ar)
                    ->searchable(['name_en', 'name_ar']),

                TextColumn::make('category')
                    ->label('Category')
                    ->badge(),

                TextColumn::make('level')
                    ->label('Level')
                    ->formatStateUsing(fn (int $state): string => str_repeat('●', $state).str_repeat('○', 5 - $state))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options(SkillCategory::class),
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
