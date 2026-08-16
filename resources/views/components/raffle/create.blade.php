<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public bool $modal = false;

    #[On('raffle::create')]
    public function open(): void
    {
        $this->$modal = true;
    }
};

?>

<div>
    @if ($modal)
        <div>
            Oi do raffle
        </div>
    @endif
</div>
