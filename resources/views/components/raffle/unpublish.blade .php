<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Raffle;

new class extends Component {
    public bool $modal = false;

    public ?int $id = null;

    #[On('raffle::unpublish')]
    public function open(int $id): void
    {
        $this->modal = true;
        $raffle = Raffle::findOrFail($id);
        $this->id = $raffle->id;
    }

    public function handle(): void
    {
        Raffle::where('id', $this->id)->update([
            'published_at' => null,
        ]);

        $this->dispatch('raffle::refresh');
        $this->reset();
    }
};
?>
<div>
    @if ($modal)
        <x-ui.modal title="Unpublishing Raffle #{{ $id }}">
            <p class="text-blue-700 font-bold mb-4 bg-blue-200 rounded border-2 border-blue-400 p-4">
                Are you sure you want to unpublish this raffle?
            </p>

            <div class="flex items-center justify-between">
                <x-ui.button type="button" wire:click="$set('modal', false)" class="bg-gray-400">No... I'm
                    OK</x-ui.button>
                <x-ui.button type="button" wire:click="handle" wire:loading.attr="disabled" wire:target="handle">Yes,
                    publish it!</x-ui.button>
            </div>
        </x-ui.modal>
    @endif
</div>
