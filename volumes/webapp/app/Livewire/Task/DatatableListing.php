<?php

namespace App\Livewire\Task;

use App\Services\TaskService;
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
    public int $projectId = 0;

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

    public function edit(string $uuid): RedirectResponse|\Illuminate\Contracts\Foundation\Application|Redirector|Application
    {
        return redirect("/tasks/$uuid/edit");
    }

    public function markDeleted(TaskService $taskService, string $uuid): void
    {
        $this->reset();

        if($taskService->taskExistsInTable($uuid))
        {
            $serviceResponse = $taskService->markTaskDeleted($uuid);

            if ($serviceResponse->getStatus()) {
                session()->flash(
                    'success',
                    "Your task, \"{$serviceResponse->getData()['model']->getName()}\", has been successfully deleted."
                );
            }
            else {
                session()->flash(
                    'failure',
                    "Your task, \"{$serviceResponse->getData()['model']->getName()}\", was not deleted."
                );
            }
        }
        else {
            session()->flash(
                'failure',
                "The task was not found."
            );
        }
    }


    /**
     * @param TaskService $taskService
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function render(TaskService $taskService): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.tasks-datatable', [
            'tasks' => $taskService->getPaginatedTasksForLivewireComponent(
                $this->searchTerm,
                $this->perPage,
                $this->sortBy,
                $this->sortDirection
            ),
        ]);
    }
}
