<?php

use Livewire\Component;

new class extends Component {
    public ?string $email = null;
};
?>

<div>
    {{ $email }}
    <form wire:submit="$refresh">
        <x-ui.input wire:model="email" label="Enter your email" name="email" />
        <x-ui.button type="submit" class="mt-4">Submit</x-ui.button>
    </form>
</div>
