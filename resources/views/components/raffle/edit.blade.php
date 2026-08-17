<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Models\Raffle;

new class extends Component {
    public bool $modal = false;

    public ?int $id = null;

    #[Validate(['required', 'string', 'min:5', 'max:255'])]
    public string $name = '';

    #[On('raffle::edit')]
    public function open(int $id): void
    {
        $this->modal = true;
        $raffle = Raffle::findOrFail($id);
        $this->id = $raffle->id;
        $this->name = $raffle->name;
    }

    public function handle(): void
    {
        $this->validate();

        Raffle::where('id', $this->id)->update([
            'name' => $this->name,
        ]);

        $this->dispatch('raffle::refresh');
        $this->reset();
    }
};
?>
<div>
    @if ($modal)
        <x-ui.modal title="Editing Raffle #{{ $id }}">
            <div>
                <form wire:submit="handle" class="space-y-4">
                    <x-ui.input label="Name" name="name" type="text" wire:model.lazy="name" />
                    <x-ui.button type="submit" class="w-full" wire:loadding.attr="disabled"
                        wire:target="handle">Save</x-ui.button>
                </form>
            </div>
        </x-ui.modal>
    @endif
</div>
