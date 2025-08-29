<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGstMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gst_masters', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('head_office');
            $table->string('branch_office');
            $table->string('temp_address');
            $table->string('gstin');
            $table->string('udyam_reg_no');
            $table->string('pincode');
            $table->string('city');
            $table->string('type');
            $table->string('issue_date');
            $table->string('expiry_date');
            $table->string('mobile');
            $table->string('email');
            $table->string('visiblity');
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
        Schema::dropIfExists('gst_masters');
    }
}
