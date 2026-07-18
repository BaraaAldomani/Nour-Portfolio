<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('read_at')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-s-envelope')
                    ->getStateUsing(fn (ContactMessage $record): bool => ! $record->isUnread()),

                TextColumn::make('name')
                    ->label('From')
                    ->description(fn (ContactMessage $record): string => $record->email)
                    ->searchable(['name', 'email'])
                    ->weight(fn (ContactMessage $record) => $record->isUnread() ? 'bold' : null),

                TextColumn::make('message')
                    ->label('Message')
                    ->limit(70)
                    ->searchable(),

                TextColumn::make('locale')
                    ->label('Site')
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('unread')
                    ->label('Unread only')
                    ->query(fn (Builder $query): Builder => $query->whereNull('read_at')),
            ])
            ->recordActions([
                // Marking read happens in ViewContactMessage::mount(), which
                // covers both this action and a direct link to the record.
                ViewAction::make(),

                Action::make('markUnread')
                    ->label('Mark unread')
                    ->icon('heroicon-o-envelope')
                    ->color('gray')
                    ->visible(fn (ContactMessage $record): bool => ! $record->isUnread())
                    ->action(fn (ContactMessage $record) => $record->forceFill(['read_at' => null])->save()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
