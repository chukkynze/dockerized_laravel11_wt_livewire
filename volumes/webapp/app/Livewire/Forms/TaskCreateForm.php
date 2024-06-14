<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class TaskCreateForm extends Form
{
    #[Rule('required|max:100')]
    public string $name;

    protected array $messages = [];
}
