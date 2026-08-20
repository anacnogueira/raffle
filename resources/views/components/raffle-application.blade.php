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
    public ?string $winner = null;
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

    #[Computed]
    public function winners(): Collection
    {
        return $this->raffle->winners()->with('applicant')->get();
    }

    public function getWinner(): void
    {
        $this->authorize('drawWinner', $this->raffle);
        if ($this->raffle->applicants()->count() < 2) {
            $this->addError('winner', 'At least two participants are required to perform the draw.');
            return;
        }

        $winners = $this->raffle->winners()->pluck('applicant_id')->toArray();
        $winner = $this->raffle->applicants()->whereNotIn('id', $winners)->inRandomOrder()->first();

        if (!$winner) {
            $this->addError('winner', 'No more participants available for the draw.');
            return;
        }

        $this->raffle->winners()->create([
            'applicant_id' => $winner->id,
        ]);
    }
};
?>

<div>
    <h1 class="text-2xl font-bold mb-4">Raffle Application :: {{ $raffle->name }}</h1>
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

    <br>
    <div class="border border-gray-200 dark:border-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-medium text-gray-800 mb-4 dark:text-gray-300">Participants</h3>
        <ul class="divide-y divide-gray-100">
            @foreach ($this->participants as $participant)
                <li class="hover:bg-gray-50 dark:hover:bg-gray-800">{{ $participant }}</li>
            @endforeach
        </ul>
    </div>
    <br />
    @if ($this->winners)
        <div
            class="relative flex flex-col items-center justify-center p-4 bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-600 rounded-lg">

            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">The winner is:</h1>
            @foreach ($this->winners as $winner)
                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $winner->applicant->email }}</p>
            @endforeach
        </div>
    @else
        @can('drawWinner', $raffle)
            <x-ui.error name="winner" />
            <x-ui.button type="button" class="mt-4" wire:click="getWinner">Draw the winner</x-ui.button>
        @endcan
    @endif

</div>
