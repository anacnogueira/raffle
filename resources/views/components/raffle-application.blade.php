<?php

use Livewire\Component;

new class extends Component {
    public ?string $email = null;
    public bool $success = false;

    public function save()
    {
        // cria o registro
        $this->success = true;
    }
};
?>

<div>
    @if ($success)
        <div class="flex flex-col items-center justify-center p-4 bg-green-100 border-1 rounded-lg border-green-300">
            <h1 class="text-2xl font-bold">Thank you for your submisstion</h1>
            <p class="mt-2">We will contact you soon.</p>
        </div>
    @else
        <form wire:submit="save">
            <x-ui.input wire:model="email" label="Enter your email" name="email" />
            <x-ui.button type="submit" class="mt-4">Submit</x-ui.button>
        </form>
    @endif
</div>
