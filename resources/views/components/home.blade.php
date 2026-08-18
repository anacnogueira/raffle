<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Raffle;

new class extends Component {
    #[Computed]
    public function raffles(): Collection
    {
        return Raffle::query()->whereNotNull('published_at')->orderBy('id', 'desc')->get();
    }
};
?>

<div>
    @foreach ($this->raffles as $raffle)
        <p>
            <a class="hover:underline hover:text-blue-400" href="{{ route('raffle.application', $raffle) }}">
                {{ $raffle->id }} - {{ $raffle->name }}
            </a>
        </p>
    @endforeach
</div>
