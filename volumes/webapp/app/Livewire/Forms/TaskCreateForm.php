<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class TaskCreateForm extends Form
{
    #[Rule('required|max:100')]
    public string $name;

    #[Rule('required|numeric')]
    public string $priority;

    #[Rule('required|exists:projects,id')]
    public int $project_id;

    protected array $messages = [
        'project_id.required' => "The task must be assigned to a project.",
        'project_id.exists' => 'Please choose an existing project.',
    ];
}
