<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use App\Models\Applicant;
use App\Models\Raffle;
use Illuminate\Support\Collection;

new class extends Component {
    public ?Raffle $raffle = null;

    public function mount(Raffle $raffle): void
    {
        $this->authorize('onlyPublished', $raffle);
        $this->raffle = $raffle;
    }
};
?>
<div>
    <h1 class="text-2xl font-bold mb-4">Raffle :: {{ $raffle->name }}</h1>
    <livewire:raffle.application :raffle="$raffle" />
    <br />
    <livewire:raffle.winners :raffle="$raffle" />
    <br />
    <livewire:raffle.draw-winner :raffle="$raffle" />
</div>
