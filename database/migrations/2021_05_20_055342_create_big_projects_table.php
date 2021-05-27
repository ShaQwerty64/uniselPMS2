<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBigProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('big_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('details')->nullable();
            $table->enum('PTJ', ['CICT','Aset','JPP']);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('default')->nullable();
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
        Schema::dropIfExists('big_projects');
    }
}
