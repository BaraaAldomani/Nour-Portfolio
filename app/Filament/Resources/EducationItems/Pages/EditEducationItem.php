<?php

namespace App\Filament\Resources\EducationItems\Pages;

use App\Filament\Resources\EducationItems\EducationItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEducationItem extends EditRecord
{
    protected static string $resource = EducationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
