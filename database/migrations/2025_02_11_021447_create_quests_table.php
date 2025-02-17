<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('mendatang');
            $table->date('due_date');
            $table->boolean('checked')->default(false);
            $table->string('color')->default('yellow');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quests');
    }
};
