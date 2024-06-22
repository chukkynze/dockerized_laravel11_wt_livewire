<?php

namespace App\Livewire\Project;

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class CreateEdit extends Component
{
    public Project $project;

    public string $name = '';
    public int $type_id = 0;
    public int $status_id = 0;

    public Collection $projectTypes;
    public Collection $projectStatuses;


    /**
     * @param ProjectService $projectService
     * @param Project $project
     * @return void
     */
    public function mount(ProjectService $projectService, Project $project): void
    {
        $this->project = $project;

        $this->name = ($this->project->getUuid() ? $this->project->getName() : $this->name);
        $this->type_id = ($this->project->getUuid() ? $this->project->getTypeId() : $this->type_id);
        $this->status_id = ($this->project->getUuid() ? $this->project->getStatusId() : $this->status_id);

        $this->projectTypes = $projectService->getAllProjectTypes()->getData()['models'];
        $this->projectStatuses = $projectService->getAllProjectStatuses()->getData()['models'];
    }


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'type_id' => 'required|exists:project_types,id',
            'status_id' => 'required|exists:project_statuses,id',
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

            'type_id.required' => "The project must have a type.",
            'type_id.exists' => 'Please choose an existing project type.',

            'status_id.required' => "The project must have a status.",
            'status_id.exists' => 'Please choose an existing status.',
        ];
    }


    /**
     * @param ProjectService $projectService
     * @return RedirectResponse|Redirector
     */
    public function create(ProjectService $projectService): RedirectResponse|Redirector
    {
        $this->validate();

        if (false !== $projectService->createProject(
                $this->all()['name'],
                $this->all()['status_id'],
                $this->all()['type_id'],
            )->getStatus()) {
            session()->flash('success', "Your project, \"$this->name\", has been created.");
        }
        else {
            session()->flash('failure', "Your project, \"$this->name\", was not created.");
        }

        return redirect()->route('projects.listing');
    }


    /**
     * @param ProjectService $projectService
     * @return RedirectResponse|Redirector
     */
    public function update(ProjectService $projectService): RedirectResponse|Redirector
    {
        $this->validate();

        if (false !== $projectService->updateProject(
                $this->project->getUuid(),
                $this->all()['name'],
                $this->all()['status_id'],
                $this->all()['type_id'],
            )->getStatus()) {
            session()->flash('success', "Your project, \"$this->name\", has been updated.");
        }
        else {
            session()->flash('failure', "Your project, \"$this->name\", was not updated.");
        }

        return redirect()->route('projects.listing');
    }


    /**
     * @return View|Application|Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.project.create-edit',[
            'project' => $this->project,
            'projectTypes' => $this->projectTypes,
            'projectStatuses' => $this->projectStatuses,
        ]);
    }
}
