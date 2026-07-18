<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Finder\Finder;
use Tests\TestCase;

/**
 * Guards the design-system rules that are easy to break by accident and hard to
 * notice once broken.
 */
final class DesignSystemTest extends TestCase
{
    /**
     * @return array<int, string>
     */
    private function bladeFiles(): array
    {
        $files = [];

        foreach (Finder::create()->files()->in(resource_path('views'))->name('*.blade.php') as $file) {
            $files[$file->getRelativePathname()] = $file->getContents();
        }

        return $files;
    }

    #[Test]
    public function blade_templates_contain_no_raw_hex_colours(): void
    {
        $offenders = [];

        foreach ($this->bladeFiles() as $name => $contents) {
            if (preg_match_all('/#[0-9a-fA-F]{3,8}\b/', $contents, $matches)) {
                $offenders[$name] = array_unique($matches[0]);
            }
        }

        $this->assertSame(
            [],
            $offenders,
            'Colours belong in tokens.css. Found raw hex in: '.json_encode($offenders),
        );
    }

    #[Test]
    public function blade_templates_use_no_off_brand_colour_utilities(): void
    {
        // The stock palette is wiped in app.css, so these would render as
        // nothing at all rather than as the wrong colour -- which is worse,
        // because it looks like a layout bug instead of a colour one.
        $stock = 'red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|'
            .'violet|purple|fuchsia|pink|rose|slate|gray|grey|zinc|stone';

        $offenders = [];

        foreach ($this->bladeFiles() as $name => $contents) {
            $pattern = '/\b(?:bg|text|border|from|to|via|fill|stroke|ring|shadow|divide)-(?:'.$stock.')(?:-\d{2,3})?\b/';

            if (preg_match_all($pattern, $contents, $matches)) {
                $offenders[$name] = array_unique($matches[0]);
            }
        }

        $this->assertSame(
            [],
            $offenders,
            'Use semantic utilities (bg-surface, text-ink, ...). Found: '.json_encode($offenders),
        );
    }

    #[Test]
    public function blade_templates_use_logical_properties_not_physical_sides(): void
    {
        // RTL is a first-class layout here, not a mirror hack. Physical
        // left/right utilities do not flip and would strand elements on the
        // wrong side in Arabic.
        $offenders = [];

        foreach ($this->bladeFiles() as $name => $contents) {
            // Strip Blade comments so guidance prose does not trip the check.
            $stripped = preg_replace('/\{\{--.*?--\}\}/s', '', $contents) ?? $contents;

            // Matched on utility *shape*, not bare prefixes -- "pr" would
            // otherwise match inside "priority" and "pl" inside "plate".
            $patterns = [
                '/\b[mp][lr]-(?:\d+(?:\.\d+)?|px|auto|full|\[[^\]]+\])\b/', // ml-4, pr-px, pl-[3rem]
                '/\brounded-[lr](?:-|\b)/',                                  // rounded-l, rounded-r-md
                '/\bborder-[lr](?:-\d+)?\b/',                                // border-l, border-r-2
                '/\btext-(?:left|right)\b/',
                '/\b(?:left|right)-(?:\d+(?:\.\d+)?|px|auto|full|\[[^\]]+\])\b/', // left-0, right-1/2
            ];

            $found = [];

            foreach ($patterns as $pattern) {
                if (preg_match_all($pattern, $stripped, $matches)) {
                    $found = [...$found, ...$matches[0]];
                }
            }

            if ($found !== []) {
                $offenders[$name] = array_values(array_unique($found));
            }
        }

        $this->assertSame(
            [],
            $offenders,
            'Use logical utilities (ms/me, ps/pe, text-start/end, border-s/e). Found: '.json_encode($offenders),
        );
    }

    #[Test]
    public function tokens_expose_exactly_three_editable_brand_colours(): void
    {
        $tokens = file_get_contents(resource_path('css/tokens.css'));

        preg_match_all('/^\s*--brand-[a-z-]+:/m', $tokens, $matches);

        $this->assertCount(
            3,
            $matches[0],
            'tokens.css must expose exactly three brand colours; everything else derives from them.',
        );
    }

    #[Test]
    public function the_stock_tailwind_palette_is_wiped(): void
    {
        $css = file_get_contents(resource_path('css/app.css'));

        $this->assertStringContainsString(
            '--color-*: initial;',
            $css,
            'app.css must wipe the stock palette so off-brand utilities cannot be used.',
        );
    }

    #[Test]
    public function reduced_motion_is_honoured(): void
    {
        $css = file_get_contents(resource_path('css/app.css'));
        $js  = file_get_contents(resource_path('js/app.js'));

        $this->assertStringContainsString('prefers-reduced-motion: reduce', $css);
        $this->assertStringContainsString('prefers-reduced-motion: reduce', $js);
    }

    #[Test]
    public function reveal_states_are_scoped_to_the_js_class(): void
    {
        // If a reveal rule were not scoped to html.js, content would be stuck
        // at opacity 0 for anyone without JavaScript, and for crawlers.
        $css = file_get_contents(resource_path('css/app.css'));

        $this->assertMatchesRegularExpression('/\.js \.reveal\b/', $css);
        $this->assertDoesNotMatchRegularExpression('/^\s*\.reveal\s*\{/m', $css);
    }
}
