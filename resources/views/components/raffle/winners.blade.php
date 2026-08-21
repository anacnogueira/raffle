<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Raffle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

new class extends Component {
    public bool $show = false;
    public Raffle $raffle;

    public function mount(Raffle $raffle): void
    {
        $this->authorize('onlyPublished', $raffle);
        $this->raffle = $raffle;
    }

    public function toggleShow(): void
    {
        $this->show = !$this->show;
    }

    #[Computed]
    public function winners(): Collection|SupportCollection
    {
        return $this->raffle->winners()->with('applicant')->get()->map(fn($winner) => $this->show ? $winner->applicant->email : preg_replace('/(?<=.{2}).(?=.*@)/u', '*', $winner->applicant->email));
    }
};
?>

<div>
    @if ($this->winners->count())
        <div
            class="relative flex flex-col items-center justify-center p-4 bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-600 rounded-lg">
            @can('drawWinner', $raffle)
                <x-ui.button type="button" wire:click="toggleShow" class="absolute top-2 right-2">
                    @if ($show)
                        Hide Winners
                    @else
                        Show Winners
                    @endif
                </x-ui.button>
            @endcan


            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">The winner is:</h1>

            @foreach ($this->winners as $winner)
                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $winner }}</p>
            @endforeach
        </div>
    @endif
</div>
