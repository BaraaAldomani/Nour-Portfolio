<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

final class Experience extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'key',
        'company_ar',
        'company_en',
        'role_ar',
        'role_en',
        'location_ar',
        'location_en',
        'start_date',
        'end_date',
        'is_current',
        'summary_ar',
        'summary_en',
        'highlights_ar',
        'highlights_en',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'start_date'    => 'date',
            'end_date'      => 'date',
            'is_current'    => 'boolean',
            'highlights_ar' => 'array',
            'highlights_en' => 'array',
            'sort_order'    => 'integer',
        ];
    }

    /**
     * @return array<int, string>
     */
    public function highlights(): array
    {
        return $this->localizedArray('highlights');
    }

    /**
     * "2024 — Present" / "٢٠٢٤ — حتى الآن", formatted for the active locale.
     */
    public function period(): string
    {
        $start = $this->formatMonth($this->start_date);

        $end = $this->is_current || $this->end_date === null
            ? __('common.present')
            : $this->formatMonth($this->end_date);

        return "{$start} — {$end}";
    }

    private function formatMonth(?Carbon $date): string
    {
        if ($date === null) {
            return '';
        }

        // Both locales use Western digits here so the timeline stays scannable
        // against the Latin company names beside it.
        return $date->format('m/Y');
    }
}
