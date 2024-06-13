<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class ProjectCreateForm extends Form
{
    #[Rule('required|max:100')]
    public string $name;

    #[Rule('required|exists:project_types,id')]
    public int $type_id;

    #[Rule('required|exists:project_statuses,id')]
    public int $status_id;

    protected array $messages = [
        'type_id.required' => "The project must have a type.",
        'type_id.exists' => 'Please choose an existing project type.',
        'status_id.required' => "The project must have a status.",
        'status_id.exists' => 'Please choose an existing project status.',
    ];
}
