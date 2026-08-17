<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Raffle;

new class extends Component {
    public bool $modal = false;
    public string $name = '';

    #[On('raffle::create')]
    public function open(): void
    {
        $this->modal = true;
    }

    public function handle(): void
    {
        Raffle::create([
            'name' => $this->name,
        ]);
        $this->dispatch('raffle::refresh');
        $this->reset();
    }
};

?>

<div>
    @if ($modal)
        <x-ui.modal title="Create New Raffle">
            <div>
                <form wire:submit="handle" class="space-y-4">
                    <x-ui.input label="Name" name="name" type="text" wire:model.defer="name"
                        placeholder="Entre Raffle name" />
                    <x-ui.button type="submit" class="w-full" wire:loadding.attr="disabled"
                        wire:target="handle">Save</x-ui.button>
                </form>
            </div>
        </x-ui.modal>
    @endif
</div>
