<?php

namespace Feature\Livewire\Project;

use App\Livewire\Project\DatatableListing;
use Livewire\Livewire;
use Tests\TestCase;

class DatatableListingTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DatatableListing::class)
            ->assertStatus(200);
    }
}
