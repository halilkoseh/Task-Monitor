<?php

// database/migrations/xxxx_xx_xx_create_tasks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
  // tasks migration dosyasında
public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('start_date');
        $table->date('due_date');
        // $table->string('status')->default('Atandi');  // Görev statüsü için yeni bir sütun
        $table->string('attachments')->nullable();
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
