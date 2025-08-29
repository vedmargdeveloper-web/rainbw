<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('invoice_type');
            $table->string('invoice_no');
            $table->string('invoice_date');
            $table->string('customer_type');
            $table->integer('customer_id');
            $table->string('customer_details');
            $table->string('delivery_id');
            $table->string('delivery_details');
            $table->string('supply_id');
            $table->string('supply_details');
            $table->integer('net_amount');
            $table->integer('net_discount');
            $table->float('total_tax',8,2); 
            $table->float('total_amount',8,2); 
            $table->string('amount_in_words'); 
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
        Schema::dropIfExists('invoices');
    }
}
