<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Raffle;

new class extends Component {
    public bool $modal = false;

    public ?Raffle $raffle = null;

    #[On('raffle::publish')]
    public function open(int $id): void
    {
        $this->modal = true;
        $this->raffle = Raffle::findOrFail($id);
    }

    public function handle(): void
    {
        $this->raffle->update([
            'published_at' => now(),
        ]);

        $this->dispatch('raffle::refresh');
        $this->reset();
    }
};
?>
<div>
    @if ($modal)
        <x-ui.modal title="Publishing Raffle #{{ $raffleid }}">
            <p class="text-blue-700 font-bold mb-4 bg-blue-200 rounded border-2 border-blue-400 p-4">
                Are you sure you want to publish this raffle?
            </p>

            <div class="flex items-center justify-between">
                <x-ui.button secondary wire:click="$set('modal', false)" class="bg-gray-400">No... I'm
                    OK</x-ui.button>
                <x-ui.button danger wire:click="handle" wire:loading.attr="disabled" wire:target="handle">Yes,
                    publish it!</x-ui.button>
            </div>
        </x-ui.modal>
    @endif
</div>
