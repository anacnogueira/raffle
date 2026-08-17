<?php

use Livewire\Component;

new class extends Component {
    public bool $modal = false;

    #[Validate(['required', 'string'])]
    public string $name = '';

    #[On('raffle::edit')]
    public function open(): void
    {
        $this->modal = true;
    }

    public function handle(): void
    {
        $this->validate();

        Raffle::create([
            'name' => $this->name,
        ]);
        $this->dispatch('raffle::refresh');
        $this->reset();
    }
};
?>

<div>
    {{-- No surplus words or unnecessary actions. - Marcus Aurelius --}}
</div>
