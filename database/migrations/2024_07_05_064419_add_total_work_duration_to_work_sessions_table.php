<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalWorkDurationToWorkSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_sessions', function (Blueprint $table) {
            $table->integer('total_work_duration')->default(0)->after('status'); // Adding the column after 'status'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_sessions', function (Blueprint $table) {
            $table->dropColumn('total_work_duration');
        });
    }
}
