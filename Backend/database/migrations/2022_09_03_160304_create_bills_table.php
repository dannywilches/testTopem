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
            $table->dateTime('date_bill');
            $table->double('value_before_iva', 16, 5);
            $table->double('iva', 16, 5);
            $table->double('total_value', 16, 5);
            $table->foreignId('customer_id')->constrained('customer');
            $table->foreignId('vendor_id')->constrained('vendor');
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
