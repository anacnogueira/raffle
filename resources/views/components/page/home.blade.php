<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Raffle;

new class extends Component {
    #[Computed]
    public function raffles(): Collection
    {
        return Raffle::query()->withCount('applicants', 'winners')->whereNotNull('published_at')->orderBy('id', 'desc')->get();
    }
};
?>

<div class="grid grid-cols-3 gap-4">
    @foreach ($this->raffles as $raffle)
        <x-ui.card href="{{ route('raffle', $raffle) }}">
            <h1 class="text-lg font-bold mb-4">
                {{ $raffle->id }} - {{ Str::limit($raffle->name, 10) }}
            </h1>

            <div class="h-full flex flex-col justify-between space-y-4">
                <p class="text-sm ">
                    {{ $raffle->applicants_count }} participants
                </p>

                <p class="text-sm ">
                    {{ $raffle->winners_count }} winners
                </p>


                <x-ui.button>
                    Join Now
                </x-ui.button>
            </div>
        </x-ui.card>
    @endforeach
</div>
