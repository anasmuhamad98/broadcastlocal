<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupers', function (Blueprint $table) {
            $table->id();
            $table->string('Grouper');
            $table->text('Meaning')->nullable();
            $table->boolean('Tack');
            $table->boolean('Free_Text_Tack');
            $table->boolean('List_A');
            $table->boolean('List_B');
            $table->boolean('Free_Text_List');
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
        Schema::dropIfExists('groupers');
    }
}
