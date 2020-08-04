<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->string("firstname");
             $table->string("lastname");
             $table->string("username");
             $table->string("email");
             $table->string("billing_address1");
             $table->string("billing_address2");
             $table->string("country");
             $table->string("state");
             $table->string("zip");
             $table->string("ship_firstname")->nullable();
             $table->string("ship_lastname")->nullable();
             $table->string("ship_address1")->nullable();
             $table->string("ship_address2")->nullable();
             $table->string("ship_country")->nullable();
             $table->string("ship_state")->nullable();
             $table->string("ship_zip")->nullable();
             $table->timestamps();
             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
