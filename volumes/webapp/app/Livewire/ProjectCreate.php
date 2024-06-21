<?php

namespace App\Livewire;

use App\Livewire\Forms\ProjectCreateForm;
use App\Services\ProjectService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ProjectCreate extends Component
{
    public ProjectCreateForm $form;

    /**
     * @throws ValidationException
     */
    public function submitForm(ProjectService $projectService): void
    {
        $this->form->validate();

        if (false !== $projectService->createProject($this->form->all())) {
            session()->flash('success', "Your project, \"{$this->form->name}\", has been created.");
        }
        else {
            session()->flash('failure', "Your project, \"{$this->form->name}\", was not created.");
        }

        $this->form->reset([
            'name' => '',
        ]);
    }

    public function render(ProjectService $projectService): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.project-create', [
            'projectTypes' => $projectService->getAllProjectTypes()->getData()['model'],
            'projectStatuses' => $projectService->getAllProjectStatuses()->getData()['model'],
        ]);
    }
}
