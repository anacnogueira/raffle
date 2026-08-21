<?php

use Livewire\Component;
use App\Models\Raffle;
use Livewire\Attributes\On;

new class extends Component {
    public ?Raffle $raffle = null;
    public ?string $winner = null;

    public function mount(Raffle $raffle): void
    {
        $this->authorize('onlyPublished', $raffle);
        $this->raffle = $raffle;
    }

    public function handle(): void
    {
        $this->authorize('drawWinner', $this->raffle);

        if ($this->raffle->applicants()->count() < 2) {
            $this->addError('winner', 'At least two participants are required to perform the draw.');

            return;
        }

        $this->roulette();

        $this->getWinner();
    }

    public function roulette()
    {
        $applicants = $this->raffle->applicants()->inRandomOrder()->pluck('email');

        foreach ($applicants as $email) {
            usleep(60_000);

            $this->stream('winner', $email, true);
        }
    }

    public function getWinner(): void
    {
        $winners = $this->raffle->winners->pluck('applicant_id')->toArray();

        $winner = $this->raffle->applicants()->whereNotIn('id', $winners)->inRandomOrder()->first();

        if (!$winner) {
            $this->addError('winner', 'No more participants available for the draw.');

            return;
        }

        $this->raffle->winners()->create([
            'applicant_id' => $winner->id,
        ]);

        $this->winner = $winner->email;

        $this->dispatch('winners:refresh')->to('raffle.winners');
        $this->js("confetti.addConfetti({
            confettiColors: [
                '#ff0a54', '#ff477e', '#ff7096', '#ff85a1', '#fbb1bd', '#f9bec7',
            ],
        })");
    }
};
?>

<div>
    @can('drawWinner', $raffle)
        <x-ui.error name="winner" />
        <x-ui.button type="button" class="mt-4" wire:click="handle">Draw the winner</x-ui.button>


        <x-ui.card class="mt-4 flex items-center align-middle justify-center font-bold text-2xl">
            <div wire:stream="winner">
                {{ $winner }}
            </div>
        </x-ui.card>
    @endcan
</div>
