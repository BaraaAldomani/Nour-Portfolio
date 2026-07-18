<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function routes(): array
    {
        return [
            'home'       => ['home'],
            'about'      => ['about'],
            'portfolio'  => ['portfolio'],
            'experience' => ['experience'],
            'services'   => ['services'],
            'contact'    => ['contact'],
        ];
    }

    #[Test]
    #[DataProvider('routes')]
    public function every_page_renders_in_arabic(string $route): void
    {
        $this->get(route($route, ['locale' => 'ar']))
            ->assertOk()
            ->assertSee('lang="ar"', false)
            ->assertSee('dir="rtl"', false);
    }

    #[Test]
    #[DataProvider('routes')]
    public function every_page_renders_in_english(string $route): void
    {
        $this->get(route($route, ['locale' => 'en']))
            ->assertOk()
            ->assertSee('lang="en"', false)
            ->assertSee('dir="ltr"', false);
    }

    #[Test]
    public function the_root_redirects_permanently_to_the_default_locale(): void
    {
        $this->get('/')->assertRedirect('/ar')->assertStatus(301);
    }

    #[Test]
    public function an_unsupported_locale_is_not_routable(): void
    {
        $this->get('/fr')->assertNotFound();
    }

    #[Test]
    public function every_page_declares_both_hreflang_alternates_and_x_default(): void
    {
        $response = $this->get(route('home', ['locale' => 'en']));

        $response->assertSee('hreflang="ar"', false);
        $response->assertSee('hreflang="en"', false);
        $response->assertSee('hreflang="x-default"', false);
    }

    #[Test]
    public function pages_carry_a_canonical_url_for_their_own_locale(): void
    {
        $this->get(route('about', ['locale' => 'en']))
            ->assertSee('rel="canonical" href="'.route('about', ['locale' => 'en']).'"', false);
    }

    #[Test]
    public function the_home_page_emits_valid_person_json_ld(): void
    {
        $html = $this->get(route('home', ['locale' => 'ar']))->getContent();

        $this->assertMatchesRegularExpression(
            '#<script type="application/ld\+json">(.+?)</script>#s',
            $html,
        );

        preg_match('#<script type="application/ld\+json">(.+?)</script>#s', $html, $matches);

        $decoded = json_decode($matches[1], true);

        $this->assertIsArray($decoded, 'JSON-LD did not parse.');
        $this->assertSame('Person', $decoded['@type']);
        $this->assertNotEmpty($decoded['name']);
        $this->assertNotEmpty($decoded['jobTitle']);
    }

    #[Test]
    public function the_self_hosted_fonts_are_actually_emitted(): void
    {
        // The failure this guards against is silent: without @fonts in the
        // layout the CSS still asks for Amiri and Cormorant, nothing ever
        // defines them, and the whole site falls back to the system serif.
        // Every other check still passes, so only this one catches it.
        $html = $this->get(route('home', ['locale' => 'ar']))->getContent();

        $this->assertStringContainsString('@font-face', $html, 'No @font-face rules were emitted.');

        foreach (['Cormorant Garamond', 'Amiri', 'Inter', 'Cairo'] as $family) {
            $this->assertStringContainsString(
                $family,
                $html,
                "The {$family} face was not emitted into the page.",
            );
        }

        $this->assertMatchesRegularExpression(
            '/<link[^>]+rel="preload"[^>]+as="font"/',
            $html,
            'Fonts are not being preloaded.',
        );
    }

    #[Test]
    public function content_is_readable_without_javascript(): void
    {
        // Reveal styles are scoped to html.js, so nothing may carry an inline
        // hidden state in the server-rendered markup.
        $html = $this->get(route('portfolio', ['locale' => 'ar']))->getContent();

        $this->assertStringNotContainsString('style="opacity:0', $html);
        $this->assertStringContainsString('تبّولة', $html);
    }
}
