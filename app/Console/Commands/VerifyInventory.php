<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Support\SettingsDefaults;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Checks the seeded database against the content inventory this site was
 * specified with. Run after `db:seed` on any environment -- it is the quickest
 * way to catch a seeder that silently half-ran.
 */
final class VerifyInventory extends Command
{
    protected $signature = 'site:verify-inventory';

    protected $description = 'Verify seeded row counts match the content inventory';

    /**
     * @var array<string, int>
     */
    private const EXPECTED = [
        'dishes'          => 14,
        'services'        => 6,
        'experiences'     => 3,
        'education_items' => 2,
        'skills'          => 14,
        'metrics'         => 4,
        'process_steps'   => 4,
    ];

    public function handle(): int
    {
        $rows   = [];
        $failed = false;

        foreach (self::EXPECTED as $table => $expected) {
            $actual = DB::table($table)->count();
            $pass   = $actual === $expected;

            $failed = $failed || ! $pass;

            $rows[] = [$pass ? 'OK' : 'FAIL', $table, $expected, $actual];
        }

        // Settings are counted per group rather than as one number, because the
        // total moves every time a key is added to SettingsDefaults.
        foreach (SettingsDefaults::all() as $group => $entries) {
            $expected = count($entries);
            $actual   = DB::table('settings')->where('group', $group)->count();
            $pass     = $actual === $expected;

            $failed = $failed || ! $pass;

            $rows[] = [$pass ? 'OK' : 'FAIL', "settings.{$group}", $expected, $actual];
        }

        $this->table(['', 'Table', 'Expected', 'Actual'], $rows);

        if ($failed) {
            $this->error('Inventory mismatch. Re-run `php artisan db:seed --force`.');

            return self::FAILURE;
        }

        $this->info('Inventory matches.');

        return self::SUCCESS;
    }
}
