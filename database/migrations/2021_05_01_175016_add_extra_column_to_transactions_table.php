<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('shipping_number')->nullable()->after('expiration_date');
            $table->timestamp('shipped_at')->nullable()->after('paid_at');
            $table->timestamp('accepted_at')->nullable()->after('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['shipping_number', 'shipped_at', 'accepted_at']);
        });
    }
}
