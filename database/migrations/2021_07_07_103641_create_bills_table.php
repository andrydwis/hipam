<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usage_id')->constrained('usages')->onDelete('cascade');
            $table->double('meter_cubic');
            $table->double('subscription');
            $table->double('cost');
            $table->double('fine')->nullable();
            $table->double('total');
            $table->enum('status', ['unpaid', 'late', 'paid']);
            $table->dateTime('paid_at')->nullable();
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
        Schema::dropIfExists('bills');
    }
}
