<?php

declare(strict_types=1);

namespace App\Filament\Resources\Metrics;

use App\Filament\Resources\Metrics\Pages\CreateMetric;
use App\Filament\Resources\Metrics\Pages\EditMetric;
use App\Filament\Resources\Metrics\Pages\ListMetrics;
use App\Filament\Resources\Metrics\Schemas\MetricForm;
use App\Filament\Resources\Metrics\Tables\MetricsTable;
use App\Models\Metric;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MetricResource extends Resource
{
    protected static ?string $model = Metric::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'label_en';

    public static function form(Schema $schema): Schema
    {
        return MetricForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MetricsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMetrics::route('/'),
            'create' => CreateMetric::route('/create'),
            'edit'   => EditMetric::route('/{record}/edit'),
        ];
    }
}
