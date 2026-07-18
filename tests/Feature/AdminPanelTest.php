<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\Settings\ThemeSettings;
use App\Filament\Resources\Dishes\Pages\CreateDish;
use App\Filament\Resources\Dishes\Pages\EditDish;
use App\Filament\Resources\Dishes\Pages\ListDishes;
use App\Models\ContactMessage;
use App\Models\Dish;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Exercises the admin panel end to end: authorisation, a full CRUD round-trip,
 * and -- the important one -- that an edit made in the dashboard is visible on
 * the public site on the very next request.
 */
final class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    #[Test]
    public function the_panel_is_closed_to_guests(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    #[Test]
    public function a_non_admin_user_cannot_reach_the_panel(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    #[Test]
    public function an_admin_reaches_the_dashboard(): void
    {
        $this->actingAs($this->admin)->get('/admin')->assertOk();
    }

    #[Test]
    public function every_content_resource_and_settings_page_loads(): void
    {
        $paths = [
            '/admin/dishes', '/admin/services', '/admin/experiences',
            '/admin/education-items', '/admin/skills', '/admin/metrics',
            '/admin/process-steps', '/admin/contact-messages',
            '/admin/theme-settings', '/admin/identity-settings', '/admin/pages-settings',
            '/admin/home-settings', '/admin/about-settings', '/admin/portfolio-settings',
            '/admin/contact-settings', '/admin/seo-settings', '/admin/image-settings',
        ];

        foreach ($paths as $path) {
            $this->actingAs($this->admin)
                ->get($path)
                ->assertOk("Expected {$path} to load.");
        }
    }

    #[Test]
    public function a_dish_can_be_created_edited_and_deleted_through_the_panel(): void
    {
        $this->actingAs($this->admin);

        // Exercise the real upload path rather than pointing at a seeded repo
        // asset -- the FileUpload field validates against the public disk, and a
        // repo path under public/images is not on it.
        Storage::fake('public');

        // --- Create ---
        Livewire::test(CreateDish::class)
            ->fillForm([
                'key'         => 'test-dish',
                // FileUpload state is always a list, even for a single file.
                'image'       => [UploadedFile::fake()->image('test-dish.jpg', 1080, 810)],
                'title_ar'    => 'طبق اختبار',
                'title_en'    => 'Test Dish',
                'category_ar' => 'أطباق ساخنة',
                'category_en' => 'Hot dishes',
                'is_featured' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $dish = Dish::query()->where('key', 'test-dish')->firstOrFail();
        $this->assertSame('Test Dish', $dish->title_en);
        $this->assertSame('طبق اختبار', $dish->title_ar);

        // --- Read: it reaches the public site immediately, in both languages ---
        $this->get(route('portfolio', ['locale' => 'en']))->assertSee('Test Dish');
        $this->get(route('portfolio', ['locale' => 'ar']))->assertSee('طبق اختبار');

        // --- Update ---
        Livewire::test(EditDish::class, ['record' => $dish->getKey()])
            ->fillForm(['title_en' => 'Renamed Dish'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('Renamed Dish', $dish->refresh()->title_en);
        $this->get(route('portfolio', ['locale' => 'en']))
            ->assertSee('Renamed Dish')
            ->assertDontSee('Test Dish');

        // --- Delete ---
        Livewire::test(ListDishes::class)
            ->callTableAction('delete', $dish->getKey());

        $this->assertDatabaseMissing('dishes', ['key' => 'test-dish']);
        $this->get(route('portfolio', ['locale' => 'en']))->assertDontSee('Renamed Dish');
    }

    #[Test]
    public function changing_the_theme_colours_retheme_the_public_site(): void
    {
        $this->actingAs($this->admin);

        // The shipped gold is present before the change.
        $this->get(route('home', ['locale' => 'ar']))->assertSee('--brand-primary: #C8A24C', false);

        Livewire::test(ThemeSettings::class)
            ->fillForm([
                'brand_primary'   => '#3B82F6',
                'brand_secondary' => '#0A0A0A',
                'brand_accent'    => '#F5F5F5',
            ])
            ->call('save');

        $this->assertDatabaseHas('settings', [
            'group' => 'theme',
            'key'   => 'brand_primary',
        ]);

        // The very next public request carries the new colour, with no rebuild
        // and no cache clear -- the ContentObserver flush is what makes this so.
        $this->get(route('home', ['locale' => 'ar']))
            ->assertSee('--brand-primary: #3B82F6', false)
            ->assertDontSee('--brand-primary: #C8A24C', false);
    }

    #[Test]
    public function editing_a_settings_page_reaches_the_public_site(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(\App\Filament\Pages\Settings\IdentitySettings::class)
            ->fillForm(['tagline_en' => 'A brand new tagline'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->get(route('home', ['locale' => 'en']))->assertSee('A brand new tagline');
    }

    #[Test]
    public function a_contact_submission_lands_in_the_inbox(): void
    {
        $this->post(route('contact.store', ['locale' => 'ar']), [
            'name'    => 'Restaurant Owner',
            'email'   => 'owner@example.com',
            'message' => 'We would like to discuss an executive chef role in Riyadh.',
        ])->assertRedirect(route('contact', ['locale' => 'ar']));

        $this->assertDatabaseHas('contact_messages', [
            'email'  => 'owner@example.com',
            'locale' => 'ar',
        ]);

        // It is unread, so the sidebar badge shows it.
        $this->assertSame('1', \App\Filament\Resources\ContactMessages\ContactMessageResource::getNavigationBadge());

        // And it is visible in the Inbox.
        $this->actingAs($this->admin)
            ->get('/admin/contact-messages')
            ->assertOk()
            ->assertSee('Restaurant Owner');
    }

    #[Test]
    public function the_honeypot_rejects_a_bot_submission(): void
    {
        $this->post(route('contact.store', ['locale' => 'en']), [
            'name'    => 'Spam Bot',
            'email'   => 'bot@example.com',
            'message' => 'Buy cheap watches at this totally legitimate website.',
            'company' => 'filled in by a bot',
        ])->assertSessionHasErrors();

        $this->assertDatabaseCount('contact_messages', 0);
    }

    #[Test]
    public function reading_a_message_clears_the_unread_badge(): void
    {
        $message = ContactMessage::create([
            'name'    => 'Someone',
            'email'   => 'someone@example.com',
            'message' => 'Hello there, I would like to get in touch about a role.',
            'locale'  => 'en',
        ]);

        $this->assertSame('1', \App\Filament\Resources\ContactMessages\ContactMessageResource::getNavigationBadge());

        $this->actingAs($this->admin)
            ->get("/admin/contact-messages/{$message->getKey()}")
            ->assertOk();

        $this->assertNotNull($message->refresh()->read_at);
        $this->assertNull(\App\Filament\Resources\ContactMessages\ContactMessageResource::getNavigationBadge());
    }

    #[Test]
    public function settings_defaults_are_shown_even_before_anything_is_saved(): void
    {
        Setting::query()->where('group', 'theme')->delete();

        $this->actingAs($this->admin);

        Livewire::test(ThemeSettings::class)
            ->assertFormSet(['brand_primary' => '#C8A24C']);
    }
}
