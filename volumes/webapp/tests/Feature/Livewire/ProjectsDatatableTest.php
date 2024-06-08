<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ProjectsDatatable;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectsDatatableTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ProjectsDatatable::class)
            ->assertStatus(200);
    }
}
