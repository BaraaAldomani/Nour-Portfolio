<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex items-center gap-3">
            @foreach ($this->getFormActionsForView() as $action)
                {{ $action }}
            @endforeach
        </div>
    </form>
</x-filament-panels::page>
