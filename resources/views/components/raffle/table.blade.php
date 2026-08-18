<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Raffle;

new class extends Component {
    use WithPagination;

    #[On('raffle::refresh')]
    public function mount() {}

    #[Computed]
    public function records(): LengthAwarePaginator
    {
        return Raffle::query()->orderBy('id', 'desc')->paginate();
    }
};
?>

<div class="space-y-4">
    <x-ui.h1 class="flex justify-between items-center">
        <span>Raffles</span>
        <x-ui.button @click="$dispatch('raffle::create')">+ Create</x-ui.button>
    </x-ui.h1>

    <x-ui.table>
        <x-ui.table.thead>
            <x-ui.table.th>ID</x-ui.table.th>
            <x-ui.table.th>Name</x-ui.table.th>
            <x-ui.table.th>Published</x-ui.table.th>
            <x-ui.table.th></x-ui.table.th>
        </x-ui.table.thead>
        <x-ui.table.tbody>
            @foreach ($this->records as $record)
                <x-ui.table.tr>
                    <x-ui.table.td>{{ $record->id }}</x-ui.table.td>
                    <x-ui.table.td>{{ $record->name }}</x-ui.table.td>
                    <x-ui.table.td>{{ $record->published_at ? 'Yes' : 'No' }}</x-ui.table.td>
                    <x-ui.table.td>
                        <x-ui.button @click="$dispatch('raffle::edit', { id: {{ $record->id }}})">Edit</x-ui.button>
                        <x-ui.button
                            @click="$dispatch('raffle::delete', { id: {{ $record->id }}})">Delete</x-ui.button>
                        @unless ($record->published_at)
                            <x-ui.button @click="$dispatch('raffle::publish', { id: {{ $record->id }}})">
                                Publish
                            </x-ui.button>
                        @else
                            <x-ui.button @click="$dispatch('raffle::unpublish', { id: {{ $record->id }}})">
                                Unpublish
                            </x-ui.button>
                        @endunless
                    </x-ui.table.td>
                </x-ui.table.tr>
            @endforeach
        </x-ui.table.tbody>
    </x-ui.table>

    {{ $this->records->links() }}
</div>
