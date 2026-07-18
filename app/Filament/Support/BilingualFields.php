<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

/**
 * Builds the bilingual field pairs every content form is made of.
 *
 * Arabic and English always sit side by side in a two-column section rather than
 * behind separate tabs, so a half-translated record is visible at a glance
 * instead of hiding one language a click away.
 */
final class BilingualFields
{
    /**
     * A single-line pair: {field}_ar and {field}_en.
     */
    public static function text(string $field, string $label, bool $required = true): Section
    {
        return Section::make($label)
            ->columns(2)
            ->schema([
                TextInput::make("{$field}_ar")
                    ->label("{$label} (Arabic)")
                    ->required($required)
                    ->maxLength(255)
                    ->extraInputAttributes(['dir' => 'rtl', 'lang' => 'ar']),

                TextInput::make("{$field}_en")
                    ->label("{$label} (English)")
                    ->required($required)
                    ->maxLength(255)
                    ->extraInputAttributes(['dir' => 'ltr', 'lang' => 'en']),
            ]);
    }

    /**
     * A multi-line pair.
     */
    public static function textarea(string $field, string $label, bool $required = false, int $rows = 4): Section
    {
        return Section::make($label)
            ->columns(2)
            ->schema([
                Textarea::make("{$field}_ar")
                    ->label("{$label} (Arabic)")
                    ->required($required)
                    ->rows($rows)
                    ->extraInputAttributes(['dir' => 'rtl', 'lang' => 'ar']),

                Textarea::make("{$field}_en")
                    ->label("{$label} (English)")
                    ->required($required)
                    ->rows($rows)
                    ->extraInputAttributes(['dir' => 'ltr', 'lang' => 'en']),
            ]);
    }

    /**
     * A json list pair, edited as tags.
     */
    public static function list(string $field, string $label, ?string $hint = null): Section
    {
        return Section::make($label)
            ->description($hint)
            ->columns(2)
            ->schema([
                TagsInput::make("{$field}_ar")
                    ->label("{$label} (Arabic)")
                    ->reorderable()
                    ->extraInputAttributes(['dir' => 'rtl', 'lang' => 'ar']),

                TagsInput::make("{$field}_en")
                    ->label("{$label} (English)")
                    ->reorderable()
                    ->extraInputAttributes(['dir' => 'ltr', 'lang' => 'en']),
            ]);
    }

    /**
     * The stable identifier every content row carries. Immutable once created:
     * seeders match on it, so editing it would fork the record on the next seed.
     */
    public static function key(): TextInput
    {
        return TextInput::make('key')
            ->label('Key')
            ->required()
            ->maxLength(96)
            ->alphaDash()
            ->unique(ignoreRecord: true)
            ->disabledOn('edit')
            ->helperText('Stable identifier. Cannot be changed after creation.');
    }
}
