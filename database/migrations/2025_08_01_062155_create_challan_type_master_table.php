<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallanTypeMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('challan_type_master', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('challan_type_master');
    }
}
