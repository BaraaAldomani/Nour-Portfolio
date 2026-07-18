<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Opening a message marks it read, which clears it from the sidebar badge.
     *
     * Done in mount() rather than an afterFill() hook: that hook belongs to
     * forms, and a ViewRecord has none, so it never fired.
     */
    public function mount(int|string $record): void
    {
        parent::mount($record);

        if ($this->record->read_at === null) {
            $this->record->forceFill(['read_at' => now()])->save();
        }
    }
}
