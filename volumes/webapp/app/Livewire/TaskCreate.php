<?php

namespace App\Livewire;

use App\Livewire\Forms\TaskCreateForm;
use App\Services\ProjectService;
use App\Services\TaskService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class TaskCreate extends Component
{
    public TaskCreateForm $form;

    /**
     * @throws ValidationException
     */
    public function submitForm(TaskService $taskService): void
    {
        $this->form->validate();

        if (false !== $taskService->createTask($this->form->all())) {
            session()->flash('success', "Your task, \"{$this->form->name}\", has been created.");
        }
        else {
            session()->flash('failure', "Your task, \"{$this->form->name}\", was not created.");
        }

        $this->form->reset([
            'name' => '',
        ]);
    }

    public function render(ProjectService $projectService): View|Application|Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.task-create', [
            'projects' => $projectService->getAllProjects()->getData()['models']
        ]);
    }
}
