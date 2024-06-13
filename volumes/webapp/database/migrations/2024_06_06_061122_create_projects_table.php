<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableName = 'projects';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists($this->tableName);
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id')->unsigned()->primary();
            $table->uuid()->unique();

            $table->string('name');
            $table->unsignedInteger('type_id')->index();
            $table->unsignedInteger('status_id')->index();

            $table->timestamps();
            $table->softDeletes();
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
