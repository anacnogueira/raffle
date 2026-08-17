<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Raffle;

new class extends Component {
    public bool $modal = false;

    public ?int $id = null;

    #[On('raffle::delete')]
    public function open(int $id): void
    {
        $this->modal = true;
        $raffle = Raffle::findOrFail($id);
        $this->id = $raffle->id;
    }

    public function handle(): void
    {
        Raffle::where('id', $this->id)->delete();

        $this->dispatch('raffle::refresh');
        $this->reset();
    }
};
?>
<div>
    @if ($modal)
        <x-ui.modal title="Deleting Raffle #{{ $id }}">
            <p class="text-red-700 font-bold mb-4 bg-red-200 rounded border-2 border-red-400 p-4">
                Are you sure you want to delete this raffle? This action cannot be undone.
            </p>

            <div class="flex items-center justify-between">
                <x-ui.button type="button" wire:click="$set('modal', false)" class="bg-gray-300">No... I'm
                    OK</x-ui.button>
                <x-ui.button type="button" wire:click="handle" wire:loading.attr="disabled" wire:target="handle">Yes,
                    delete it!</x-ui.button>
            </div>
        </x-ui.modal>
    @endif
</div>
