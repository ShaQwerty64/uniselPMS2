<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsHistorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('projects_historys')){// tem. solution
            Schema::create('projects_historys', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id')->nullable();//->constrained('users')
                $table->unsignedBigInteger('user_id')->nullable();//->constrained()
                $table->unsignedBigInteger('big_project_id')->nullable();//->constrained()
                $table->unsignedBigInteger('sub_project_id')->nullable();//->constrained()
                $table->enum('PTJ', ['CICT','Aset','JPP'])->nullable();
                $table->boolean('all_admin');
                $table->text('details')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_historys');//do not work??
    }
}
