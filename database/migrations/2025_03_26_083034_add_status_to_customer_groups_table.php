<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('customer_groups', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('name'); // Thêm cột status
        });
    }

    public function down()
    {
        Schema::table('customer_groups', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
