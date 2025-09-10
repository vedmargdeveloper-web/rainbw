<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSacCodeToItemsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('sac_code')->nullable()->after('item_id');
        });

        Schema::table('quotations_items', function (Blueprint $table) {
            $table->string('sac_code')->nullable()->after('item_id');
        });

        Schema::table('bookings_items', function (Blueprint $table) {
            $table->string('sac_code')->nullable()->after('item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn('sac_code');
        });

        Schema::table('quotations_items', function (Blueprint $table) {
            $table->dropColumn('sac_code');
        });

        Schema::table('bookings_items', function (Blueprint $table) {
            $table->dropColumn('sac_code');
        });
    }
}
