<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('item_id');
            $table->string('hsn_code');
            $table->string('description');
            $table->integer('item');
            $table->integer('rate');
            $table->integer('quantity');
            $table->integer('days');
            $table->float('gross_amount',8,2);
            $table->string('discount');
            $table->string('cgst');
            $table->string('igst');
            $table->string('sgst');
            $table->float('tax_amount',8,2);
            $table->float('total_amount',8,2);
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
        Schema::dropIfExists('invoice_items');
    }
}
