<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callsigns', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('MHW');
            $table->string('SIS');
            $table->string('JBT');
            $table->string('LKU');
            $table->string('KST');
            $table->string('LKR');
            $table->string('LTP');
            $table->string('LHN');
            $table->string('LMA');
            $table->string('LAJ');
            $table->string('PRU');
            $table->string('KLN');
            $table->string('SGR');
            $table->string('PHG');
            $table->string('PRK');
            $table->string('TGU');
            $table->string('KDH');
            $table->string('KBU');
            $table->string('JRI');
            $table->string('MHU');
            $table->string('LDG');
            $table->string('HDN');
            $table->string('GMA');
            $table->string('PDR');
            $table->string('PRA');
            $table->string('PDA');
            $table->string('GNY');
            $table->string('SRG');
            $table->string('GNS');
            $table->string('PUS');
            $table->string('YUU');
            $table->string('BNG');
            $table->string('JRG');
            $table->string('PRI');
            $table->string('TDK');
            $table->string('TSA');
            $table->string('SGY');
            $table->string('STG');
            $table->string('SPL');
            $table->string('SJH');
            $table->string('TAR');
            $table->string('TRZ');
            $table->string('GGH');
            $table->string('TGH');
            $table->string('HTH');
            $table->string('PYU');
            $table->string('BTS');
            $table->string('KTA');
            $table->string('KBM');
            $table->string('KRS');
            $table->string('SDG');
            $table->string('BDK');
            $table->string('RCG');
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
        Schema::dropIfExists('callsigns');
    }
}
