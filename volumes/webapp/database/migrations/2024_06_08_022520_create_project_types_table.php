<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableName = 'project_types';

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

        $newModels = [
            [
                'id'            =>  1,
                'name'          =>  'APP',
                'display_name'  =>  'App',
                'description'   =>  'A project to create an app.',
                'enabled'       =>  1,
                'sort_order'    =>  1,
            ],
            [
                'id'            =>  2,
                'name'          =>  'SAAS',
                'display_name'  =>  'SaaS',
                'description'   =>  'A Software-as-a-Service project.',
                'enabled'       =>  1,
                'sort_order'    =>  2,
            ],
            [
                'id'            =>  3,
                'name'          =>  'DEVOPS',
                'display_name'  =>  'DevOps',
                'description'   =>  'A DevOps project.',
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
