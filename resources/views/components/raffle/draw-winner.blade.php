<?php

use Livewire\Component;
use App\Models\Raffle;

new class extends Component {
    public ?Raffle $raffle = null;

    public function mount(Raffle $raffle): void
    {
        $this->authorize('onlyPublished', $raffle);
        $this->raffle = $raffle;
    }

    public function getWinner(): void
    {
        $this->authorize('drawWinner', $this->raffle);

        if ($this->raffle->applicants()->count() < 2) {
            $this->addError('winner', 'At least two participants are required to perform the draw.');

            return;
        }

        $winners = $this->raffle->winners->pluck('applicant_id')->toArray();

        $winner = $this->raffle->applicants()->whereNotIn('id', $winners)->inRandomOrder()->first();

        if (!$winner) {
            $this->addError('winner', 'No more participants available for the draw.');

            return;
        }

        $this->raffle->winners()->create([
            'applicant_id' => $winner->id,
        ]);
    }
};
?>

<div>
    @can('drawWinner', $raffle)
        <x-ui.error name="winner" />
        <x-ui.button type="button" class="mt-4" wire:click="getWinner">Draw the winner</x-ui.button>
    @endcan
</div>
