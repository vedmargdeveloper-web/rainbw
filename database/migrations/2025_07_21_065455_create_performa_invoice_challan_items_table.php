<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformaInvoiceChallanItemsTable extends Migration
{
    public function up()
    {
        Schema::create('performa_invoice_challan_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('challan_id');
            $table->unsignedInteger('item_id');
            $table->string('sac_code')->nullable();
            $table->string('hsn_code');
            $table->string('description');
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->string('item');
            $table->integer('rate');
            $table->integer('quantity');
            $table->integer('days');
            $table->string('month')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('discount')->default('0');
            $table->string('cgst');
            $table->string('igst');
            $table->string('sgst');
            $table->double('tax_amount', 18, 2);
            $table->double('total_amount', 18, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('performa_invoice_challan_items');
    }
}
