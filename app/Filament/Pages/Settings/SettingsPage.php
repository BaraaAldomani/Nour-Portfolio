<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use App\Models\Setting;
use App\Services\SiteContent;
use App\Support\SettingsDefaults;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

/**
 * The base every settings page extends.
 *
 * A subclass supplies three things: which settings `group` it edits, and a form
 * schema. Defaults come from SettingsDefaults -- the same class the seeder reads
 * -- so a key added there appears here with no further work and cannot drift.
 */
abstract class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.settings';

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    /** The settings group this page owns. */
    abstract public static function group(): string;

    /**
     * @return array<int, mixed>
     */
    abstract public function formSchema(): array;

    /**
     * @return array<string, mixed>
     */
    public function defaultValues(): array
    {
        return SettingsDefaults::group(static::group());
    }

    public function mount(): void
    {
        // Stored values layered over the defaults, so a key that has never been
        // saved still shows its shipped value rather than an empty box.
        $stored = Setting::query()
            ->where('group', static::group())
            ->pluck('value', 'key')
            ->all();

        $this->form->fill([...$this->defaultValues(), ...$stored]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->formSchema())
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        DB::transaction(function () use ($state): void {
            foreach ($state as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['group' => static::group(), 'key' => $key],
                    ['value' => $value],
                );
            }
        });

        // Belt and braces: the ContentObserver already flushes on each save, but
        // this makes the page's contract explicit rather than implicit.
        app(SiteContent::class)->flush();

        Notification::make()
            ->title('Saved')
            ->body('The public site is updated.')
            ->success()
            ->send();
    }

    /**
     * @return array<int, Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save changes')
                ->submit('save'),
        ];
    }

    public function getFormActionsForView(): array
    {
        return $this->getFormActions();
    }
}
