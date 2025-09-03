<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformaInvoiceChallansTable extends Migration
{
    public function up()
    {
        Schema::create('performa_invoice_challans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('challan_type')->nullable();
            $table->string('ref_pi_no')->nullable();
            $table->unsignedInteger('gst_id')->nullable();
            $table->string('challan_no')->nullable();
            $table->string('challan_date')->nullable();
            $table->string('billing_date')->nullable();
            $table->string('event_time')->nullable();
            $table->string('customer_type')->nullable();
            $table->string('readyness')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->text('customer_details')->nullable();
            $table->string('delivery_id')->nullable();
            $table->text('delivery_details')->nullable();
            $table->string('supply_id')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->text('supply_details')->nullable();
            $table->integer('net_amount')->nullable();
            $table->bigInteger('net_discount')->nullable();
            $table->double('total_tax', 18, 2)->nullable();
            $table->double('total_amount', 18, 2)->nullable();
            $table->string('dayormonth')->nullable();
            $table->unsignedInteger('compition')->nullable();
            $table->text('gst_details')->nullable();
            $table->string('amount_in_words')->nullable();
            $table->unsignedInteger('original_challan_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('performa_invoice_challans');
    }
}

