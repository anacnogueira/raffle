<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Features\SupportPagination\HandlesPagination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Raffle;

new class extends Component {
    use HandlesPagination;

    #[Computed]
    public function records(): LengthAwarePaginator
    {
        return Raffle::query()->paginate();
    }
};
?>

<div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th></th>
            </tr>

        </thead>

        <tbody>
            @foreach ($this->records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>...</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $this->records->links() }}
</div>
