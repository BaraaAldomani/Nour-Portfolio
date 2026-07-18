<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'locale',
        'ip',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }
}
