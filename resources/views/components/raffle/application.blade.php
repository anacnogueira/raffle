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
    public ?string $email = null;
    public bool $success = false;

    public function mount(Raffle $raffle): void
    {
        $this->authorize('onlyPublished', $raffle);
        $this->raffle = $raffle;
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
        $this->raffle->applicants()->create([
            'email' => $this->email,
        ]);
        $this->success = true;
    }

    #[Computed]
    public function participants(): Collection
    {
        return $this->raffle->applicants()->get()->map(fn($applicant) => preg_replace('/(?<=.{2}).(?=.*@)/u', '*', $applicant->email));
    }
};
?>

<div>
    @if ($success)
        <div
            class="flex flex-col items-center justify-center p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Thank you for your submission!</h1>
            <p class="mt-2 text-gray-700 dark:text-gray-300">We will contact you soon.</p>
        </div>
    @else
        <form wire:submit="save">
            <x-ui.input wire:model="email" label="Enter your email" name="email" />

            <x-ui.button type="submit" class="mt-4">Submit</x-ui.button>
        </form>
    @endif

    <br /><br />
    <div class="border border-gray-200 dark:border-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-medium text-gray-800 mb-4 dark:text-gray-300">
            Participants
            <span class="text-sm text-gray-500 dark:text-gray-400">({{ count($this->participants) }})</span>
        </h3>
        <ul class="divide-y divide-gray-100">
            @foreach ($this->participants as $participant)
                <li class="hover:bg-gray-50 dark:hover:bg-gray-800">{{ $participant }}</li>
            @endforeach
        </ul>
    </div>
    <br />
</div>
