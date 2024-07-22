<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOffdayDateToOffdaysTable extends Migration
{
    public function up()
    {
        Schema::table('offdays', function (Blueprint $table) {
            $table->date('offday_date')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('offdays', function (Blueprint $table) {
            $table->dropColumn('offday_date');
        });
    }
}
