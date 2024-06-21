<?php

namespace App\Livewire;

use App\Services\ProjectService;
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
    public string $searchTerm = '';

    #[Url(history:true)]
    public string $sortDirection = 'desc';

    #[Url(history:true)]
    public string $sortBy = 'created_at';

    public int $projectTypeId = 0;
    public int $projectStatusId = 0;

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

    public function edit(string $uuid): void
    {
        dd($uuid);
    }

    public function markDeleted(ProjectService $projectService, string $uuid): void
    {
        $this->reset();

        if($projectService->projectExistsInTable($uuid))
        {
            $serviceResponse = $projectService->markProjectDeleted($uuid);

            if ($serviceResponse->getStatus()) {
                session()->flash(
                    'success',
                    "Your project, \"{$serviceResponse->getData()['model']->getName()}\", has been successfully deleted."
                );
            }
            else {
                session()->flash(
                    'failure',
                    "Your project, \"{$serviceResponse->getData()['model']->getName()}\", was not deleted."
                );
            }
        }
        else {
            session()->flash(
                'failure',
                "The project was not found."
            );
        }
    }


    /**
     * @param ProjectService $projectService
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function render(ProjectService $projectService): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.projects-datatable', [
            'projects' => $projectService->getPaginatedProjectsForLivewireComponent(
                $this->searchTerm,
                $this->projectTypeId,
                $this->projectStatusId,
                $this->perPage,
                $this->sortBy,
                $this->sortDirection
            ),
            'projectTypes' => $projectService->getAllProjectTypes()->getData()['models'],
            'projectStatuses' => $projectService->getAllProjectStatuses()->getData()['models'],
        ]);
    }
}
