<?php

namespace App\Livewire\Project;

use App\Exceptions\RepositoryException;
use App\Services\ProjectService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DatatableListing extends Component
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

    /**
     * @return void
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }


    /**
     * @param string $columnNane
     * @return void
     */
    public function setSortBy(string $columnNane): void
    {
        if($this->sortBy === $columnNane){
            $this->sortDirection = ($this->sortDirection == 'desc' ? 'asc' : 'desc');
            return;
        }

        $this->sortBy = $columnNane;
        $this->sortDirection = 'desc';
    }


    /**
     * @param string $uuid
     * @return RedirectResponse|\Illuminate\Contracts\Foundation\Application|Redirector|Application
     */
    public function edit(string $uuid): RedirectResponse|\Illuminate\Contracts\Foundation\Application|Redirector|Application
    {
        return redirect("/projects/$uuid/edit");
    }


    /**
     * @param ProjectService $projectService
     * @param string $uuid
     * @return void
     * @throws RepositoryException
     */
    public function markDeleted(ProjectService $projectService, string $uuid): void
    {
        $this->reset();

        if($projectService->doesProjectIdentifiedByUuidAlreadyExist($uuid))
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
     * @throws RepositoryException
     */
    public function render(ProjectService $projectService): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.project.datatable-listing', [
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
