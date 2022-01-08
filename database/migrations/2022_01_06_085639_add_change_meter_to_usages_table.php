<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeMeterToUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usages', function (Blueprint $table) {
            //
            $table->boolean('change_meter')->default(false)->after('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usages', function (Blueprint $table) {
            //
            $table->dropColumn('change_meter');
        });
    }
}
