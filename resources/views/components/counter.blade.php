<?php

use Livewire\Component;

new class extends Component {
    public $count = 0;

    public function add()
    {
        $this->count++;
    }
};
?>

<div>
    Count: {{ $count }}
    <button type="button" class="bg-white text-blue-300 border-2 border-yellow-400" wire:click="add">Incrementar</button>
</div>
