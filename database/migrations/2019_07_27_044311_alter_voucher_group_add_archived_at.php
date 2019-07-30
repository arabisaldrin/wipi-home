<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVoucherGroupAddArchivedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voucher_groups', function (Blueprint $table) {
            $table->dateTime('archived_at')->nullable();
            $table->renameColumn('date_printed', 'printed_at');
            $table->renameColumn('date_released', 'released_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voucher_groups', function (Blueprint $table) {
            //
        });
    }
}
