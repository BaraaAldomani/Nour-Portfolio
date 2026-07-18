<?php

declare(strict_types=1);

namespace App\Filament\Resources\Dishes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DishesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->height(48)
                    ->width(64),

                TextColumn::make('title_en')
                    ->label('Title')
                    ->description(fn ($record): string => $record->title_ar)
                    ->searchable(['title_en', 'title_ar'])
                    ->sortable(),

                TextColumn::make('category_en')
                    ->label('Category')
                    ->badge()
                    ->searchable(),

                IconColumn::make('is_featured')
                    ->label('Home')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category_en')
                    ->label('Category')
                    ->options(fn (): array => \App\Models\Dish::query()
                        ->distinct()
                        ->orderBy('category_en')
                        ->pluck('category_en', 'category_en')
                        ->all()),
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
