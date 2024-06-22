<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Rules\DueDateMustBeAfterStartDate;
use App\Services\ProjectService;
use App\Services\TaskService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreateEdit extends Component
{
    public Task $task;

    public string $name = '';
    public int $priority = 0;
    public string $start_dt;
    public string $due_by_dt;
    public int $project_id = 0;

    public Collection $allProjects;


    /**
     * @param ProjectService $projectService
     * @param Task $task
     * @return void
     */
    public function mount(ProjectService $projectService, Task $task): void
    {
        $this->task = $task;

        $this->name = ($this->task->getUuid() ? $this->task->getName() : $this->name);
        $this->priority = ($this->task->getUuid() ? $this->task->getPriority() : $this->priority);
        $this->start_dt = ($this->task->getUuid() ? $this->task->getStartDt() : $this->start_dt);
        $this->due_by_dt = ($this->task->getUuid() ? $this->task->getDueByDt() : $this->due_by_dt);
        $this->project_id = ($this->task->getUuid() ? $this->task->getProjectId() : $this->project_id);

        $this->allProjects = $projectService->getAllProjects()->getData()['models'];
    }


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'priority' => 'required|numeric',
            'start_dt' => 'required|date',
            'due_by_dt' => ['required', 'date', new DueDateMustBeAfterStartDate()],
            'project_id' => 'required|exists:projects,id',
        ];
    }


    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => "The task name is required.",
            'name.max' => "The task name cannot be more than 100 characters.",

            'priority.required' => "The task priority is required.",
            'priority.numeric' => "The task priority must be a number.",

            'start_dt.required' => "The start date of the task is required.",
            'start_dt.date' => "The start date must be a valid date.",

            'due_by_dt.required' => "The due by date of the task is required.",
            'due_by_dt.date' => "The due by date must be a valid date.",

            'project_id.required' => "The task must be assigned to a project.",
            'project_id.exists' => 'Please choose an existing project.',
        ];
    }


    /**
     * @param TaskService $taskService
     * @return RedirectResponse|Redirector
     */
    public function create(TaskService $taskService): RedirectResponse|Redirector
    {
        $this->validate();

        if (false !== $taskService->createTask($this->all())) {
            session()->flash('success', "Your task, \"$this->name\", has been created.");
        }
        else {
            session()->flash('failure', "Your task, \"$this->name\", was not created.");
        }

        return redirect()->route('tasks.listing');
    }


    /**
     * @param TaskService $taskService
     * @return RedirectResponse|Redirector
     */
    public function update(TaskService $taskService): RedirectResponse|Redirector
    {
        $this->validate();

        if (false !== $taskService->createTask($this->all())) {
            session()->flash('success', "Your task, \"$this->name\", has been updated.");
        }
        else {
            session()->flash('failure', "Your task, \"$this->name\", was not updated.");
        }

        return redirect()->route('tasks.listing');
    }


    /**
     * @return View|Application|Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.task-create-edit-form', [
            'task' => $this->task,
            'projects' => $this->allProjects
        ]);
    }

}
