<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_historys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained()->nullable();
            $table->foreignId('user_id')->constrained()->nullable();
            $table->foreignId('big_project_id')->constrained()->nullable();
            $table->foreignId('sub_project_id')->constrained()->nullable();
            $table->enum('PTJ', ['CICT','Aset','JPP']);
            $table->boolean('all_admin');
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_history');
    }
}
