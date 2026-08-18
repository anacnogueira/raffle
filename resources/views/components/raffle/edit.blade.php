<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Models\Raffle;
use Illuminate\Validation\Rule;

new class extends Component {
    public bool $modal = false;

    public ?Raffle $raffle = null;

    public function rules(): array
    {
        return [
            'raffle.name' => ['required', 'string', 'min:5', 'max:255', Rule::unique('raffles', 'name')->ignore($this->raffle)],
        ];
    }

    #[On('raffle::edit')]
    public function open(int $id): void
    {
        $this->modal = true;
        $this->raffle = Raffle::findOrFail($id);
    }

    public function handle(): void
    {
        $this->validate();

        $this->raffle->save();

        $this->dispatch('raffle::refresh');
        $this->reset();
    }
};
?>
<div>
    @if ($modal)
        <x-ui.modal title="Editing Raffle #{{ $raffle->id }}">
            <div>
                <form wire:submit="handle" class="space-y-4">
                    <x-ui.input label="Name" name="name" type="text" wire:model.lazy="raffle.name" />
                    <x-ui.button type="submit" class="w-full" wire:loadding.attr="disabled"
                        wire:target="handle">Save</x-ui.button>
                </form>
            </div>
        </x-ui.modal>
    @endif
</div>
