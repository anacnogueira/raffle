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
    public ?string $email = '';
    public bool $success = false;

    public function mount(): void
    {
        $this->raffle = Raffle::InRandomOrder()->first();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', Rule::unique('applicants', 'email', $this->email)->where('raffle_id', $this->raffle->id)],
        ];
    }

    public function save()
    {
        $this->validate();
        Applicant::create([
            'raffle_id' => $this->raffle->id,
            'email' => $this->email,
        ]);
        $this->success = true;
    }

    #[Computed]
    public function participants(): Collection
    {
        return $this->raffle->applicants ? $this->raffle->applicants->map(fn($applicant) => preg_replace('/(?<=.{2}).(?=.*@)/u', '*', $applicant->email)) : Collection::empty();
    }
};
?>

<div>
    <h1 class="text-2xl font-bold mb-4">Raffle Application :: {{ $raffle->name }}</h1>
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

    <br>
    <div class="border border-gray-200 rounded-lg p-4">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Participants</h3>
        <ul class="divide-y divide-gray-100">
            @foreach ($this->participants as $participant)
                <li class="py-2 px-2 hover:bg-gray-50">{{ $participant }}</li>
            @endforeach
        </ul>
    </div>
</div>
