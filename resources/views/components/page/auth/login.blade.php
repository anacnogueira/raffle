<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

new class extends Component {
    #[Validate(['required', 'email'])]
    public string $email = '';

    #[Validate(['required', 'string'])]
    public string $password = '';

    public function handle()
    {
        $this->validate();

        $this->ensureNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], true)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->rateKey());

        Session::regenerate();

        $this->redirectRoute('home');
    }

    private function ensureNotRateLimited(): void
    {
        if (RateLimiter::tooManyAttempts($this->rateKey(), 5)) {
            $seconds = RateLimiter::availableIn($this->rateKey());

            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please, try again $seconds seconds",
            ]);
        }

        RateLimiter::hit($this->rateKey());
    }

    private function rateKey(): string
    {
        return str($this->email . '|' . request()->ip())
            ->replace('@', '_at_')
            ->replace('.', '_')
            ->slug();
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
