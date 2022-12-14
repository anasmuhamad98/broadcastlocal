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
            $table->boolean('Tack_1')->default(0);
            $table->boolean('Tack_2')->default(0);
            $table->boolean('Tack_3')->default(0);
            $table->boolean('Tack_4')->default(0);
            $table->boolean('Free_Text_Tack_1')->default(0);
            $table->boolean('Free_Text_Tack_2')->default(0);
            $table->boolean('Free_Text_Tack_3')->default(0);
            $table->boolean('Free_Text_Tack_4')->default(0);
            $table->boolean('Free_Text_Tack_5')->default(0);
            $table->boolean('Free_Text_Tack_6')->default(0);
            $table->boolean('List_A')->default(0);
            $table->boolean('List_B')->default(0);
            $table->boolean('List_C')->default(0);
            $table->boolean('Free_Text_List')->default(0);
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
