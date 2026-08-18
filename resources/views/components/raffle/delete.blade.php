<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Raffle;

new class extends Component {
    public bool $modal = false;

    public ?Raffle $raffle = null;

    #[On('raffle::delete')]
    public function open(int $id): void
    {
        $this->modal = true;
        $this->raffle = Raffle::findOrFail($id);
    }

    public function handle(): void
    {
        $this->raffle->delete();

        $this->dispatch('raffle::refresh');
        $this->reset();
    }
};
?>
<div>
    @if ($modal)
        <x-ui.modal title="Deleting Raffle #{{ $raffle->id }}">
            <p class="text-red-700 font-bold mb-4 bg-red-200 rounded border-2 border-red-400 p-4">
                Are you sure you want to delete this raffle? This action cannot be undone.
            </p>

            <div class="flex items-center justify-between">
                <x-ui.button secondary wire:click="$set('modal', false)" class="bg-gray-400">No... I'm
                    OK</x-ui.button>
                <x-ui.button danger wire:click="handle" wire:loading.attr="disabled" wire:target="handle">Yes,
                    delete it!</x-ui.button>
            </div>
        </x-ui.modal>
    @endif
</div>
