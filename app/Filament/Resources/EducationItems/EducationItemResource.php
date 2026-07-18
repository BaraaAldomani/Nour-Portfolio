<?php

declare(strict_types=1);

namespace App\Filament\Resources\EducationItems;

use App\Filament\Resources\EducationItems\Pages\CreateEducationItem;
use App\Filament\Resources\EducationItems\Pages\EditEducationItem;
use App\Filament\Resources\EducationItems\Pages\ListEducationItems;
use App\Filament\Resources\EducationItems\Schemas\EducationItemForm;
use App\Filament\Resources\EducationItems\Tables\EducationItemsTable;
use App\Models\EducationItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EducationItemResource extends Resource
{
    protected static ?string $model = EducationItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Education';

    protected static ?string $recordTitleAttribute = 'credential_en';

    public static function form(Schema $schema): Schema
    {
        return EducationItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EducationItemsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListEducationItems::route('/'),
            'create' => CreateEducationItem::route('/create'),
            'edit'   => EditEducationItem::route('/{record}/edit'),
        ];
    }
}
