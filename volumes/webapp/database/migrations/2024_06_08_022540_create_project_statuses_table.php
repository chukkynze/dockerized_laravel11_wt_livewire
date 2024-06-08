<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableName = 'project_statuses';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists($this->tableName);
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();

            $table->string('name', 200);
            $table->string('display_name', 200);
            $table->string('description', 255)->default('');

            $table->tinyInteger('enabled')->default(0);
            $table->unsignedInteger('sort_order')->default(0);

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->unique(['name']);
        });

        $newModels	=	[
            [
                'id'            =>  1,
                'name'          =>  'TODO',
                'display_name'  =>  'To-Do',
                'description'   =>  'The project is yet to be started.',
                'enabled'       =>  1,
                'sort_order'    =>  1,
            ],
            [
                'id'            =>  2,
                'name'          =>  'IN_PROGRESS',
                'display_name'  =>  'In Progress',
                'description'   =>  'The project has started.',
                'enabled'       =>  1,
                'sort_order'    =>  2,
            ],
            [
                'id'            =>  3,
                'name'          =>  'DONE',
                'display_name'  =>  'Done',
                'description'   =>  'The project is done.',
                'enabled'       =>  1,
                'sort_order'    =>  3,
            ],
        ];

        if(count($newModels) >= 1)
        {
            DB::table($this->tableName)->insert($newModels);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
