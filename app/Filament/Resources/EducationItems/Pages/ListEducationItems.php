<?php

namespace App\Filament\Resources\EducationItems\Pages;

use App\Filament\Resources\EducationItems\EducationItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEducationItems extends ListRecords
{
    protected static string $resource = EducationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
