<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectsDatatable extends Component
{
    use WithPagination;

    #[Url]
    public int $perPage = 5;

    #[Url(history:true)]
    public string $search = '';

    public int $projectType = 0;
    public int $projectStatus = 0;

    #[Url(history:true)]
    public string $sortDirection = 'desc';

    #[Url(history:true)]
    public string $sortBy = 'created_at';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setSortBy(string $columnNane): void
    {
        if($this->sortBy === $columnNane){
            $this->sortDirection = ($this->sortDirection == 'desc' ? 'asc' : 'desc');
            return;
        }

        $this->sortBy = $columnNane;
        $this->sortDirection = 'desc';
    }

    public function delete(string $uuid): void
    {
        if (Project::whereUuid($uuid)->exists()) {
            Project::whereUuid($uuid)->delete();
        }
    }


    /**
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.projects-datatable', [
            'projects' => Project::search($this->search)
                ->when($this->projectType !== 0, function ($query){
                    $query->where('type_id', $this->projectType);
                })
                ->when($this->projectStatus !== 0, function ($query){
                    $query->where('status_id', $this->projectStatus);
                })
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage),
            'projectTypes' => ProjectType::all(),
            'projectStatuses' => ProjectStatus::all(),
        ]);
    }
}
