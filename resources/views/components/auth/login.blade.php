<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    #[Validate(['required', 'email'])]
    public string $email = '';

    #[Validate(['required', 'string'])]
    public string $password = '';

    public function handle()
    {
        $this->validate();
        if (
            Auth::attempt(
                [
                    'email' => $this->email,
                    'password' => $this->password,
                ],
                true,
            )
        ) {
            session()->regenerate();
            $this->redirectRoute('home');
        }

        $this->addError('email', 'Invalid credentials');
    }
};
?>

<x-ui.card>
    <h1 class="text-2xl font-bold mb-4">Login</h1>

    <form wire:submit="handle" class="space-y-4">
        <x-ui.input wire:model="email" label="email" type="email" name="email" />
        <x-ui.input wire:model="password" label="password" type="password" name="password" />

        <x-ui.button type="submit" class="mt-4">Login</x-ui.button>
    </form>
</x-ui.card>
