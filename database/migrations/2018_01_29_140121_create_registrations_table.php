<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->increments('id');
	        $table->date('workday');
	        $table->double('amount', 10, 2);
	        $table->text('description')->nullable();
	        $table->integer('customer_id')->unsigned();
	        $table->integer('project_id')->unsigned();
	        $table->integer('user_id')->unsigned();
	        $table->timestamps();

	        $table->foreign('customer_id')->references('id')->on('customers');
	        $table->foreign('project_id')->references('id')->on('projects');
	        $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
