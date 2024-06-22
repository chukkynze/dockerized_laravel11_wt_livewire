<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Search extends Component
{
    public $searchProjectTerm;
    public $results;

    public function resetDropdown(): void
    {
        $this->searchProjectTerm = '';
        $this->results = [];
    }

    public function mount(): void
    {
        $this->resetDropdown();
    }

    public function updatedSearchProjectTerm(): void
    {
        if (strlen($this->searchProjectTerm) >= 2) {
            $this->results = Project::where(
                'name',
                'like',
                "%$this->searchProjectTerm%"
            )
            ->get()
            ->toArray();
        }
    }

    public function render(): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.search-projects');
    }
}
