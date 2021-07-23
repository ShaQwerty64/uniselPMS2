<?php

namespace App\Http\Livewire;

use App\Models\ProjectsHistory;
use Carbon\Carbon;
use Livewire\Component;

class DeleteHistory extends Component
{
    public int $monthsAfterToDelete = 3;
    public int $toDeleteCount = 0;

    public function render()
    {
        $this->toDeleteCount = ProjectsHistory::where('created_at', '<=' , Carbon::now()->subMonths($this->monthsAfterToDelete)->toDateTimeString())->count();
        return view('livewire.delete-history');
    }

    public function comfirmDelete()
    {
        ProjectsHistory::where('created_at', '<=' , Carbon::now()->subMonths($this->monthsAfterToDelete)->toDateTimeString())->delete();
        return redirect()->route('dashboard');
    }
}
