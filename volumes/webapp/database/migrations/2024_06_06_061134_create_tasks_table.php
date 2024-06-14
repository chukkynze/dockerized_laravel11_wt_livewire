<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableName = 'tasks';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists($this->tableName);
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id')->unsigned()->primary();
            $table->uuid()->unique();

            $table->unsignedInteger('project_id');

            $table->string('name');
            $table->unsignedInteger('priority')->index();
            $table->dateTime('start_dt')->default(date('Y-m-d h:i:s', strtotime('now')));
            $table->dateTime('due_by_dt')->default(date('Y-m-d h:i:s', strtotime('+1 week')));

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table($this->tableName, function(Blueprint $table)
        {
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
