<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phoneNumber')->nullable();
            $table->string('linkedinAddress')->nullable();
            $table->string('portfolioLink')->nullable();
            $table->string('profilePic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phoneNumber');
            $table->dropColumn('linkedinAddress');
            $table->dropColumn('portfolioLink');
            $table->dropColumn('profilePic');
        });
    }
}
