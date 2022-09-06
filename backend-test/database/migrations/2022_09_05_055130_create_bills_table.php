<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bill_number')->unique();
            $table->dateTime('date_bill')->nullable();
            $table->double('value_before_iva', 16, 5)->nullable();
            $table->double('iva', 16, 5)->nullable();
            $table->double('total_value', 16, 5)->nullable();
            $table->string('customer');
            $table->string('vendor');
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
        Schema::dropIfExists('bill');
    }
};
