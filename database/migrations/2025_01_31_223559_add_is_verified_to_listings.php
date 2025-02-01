<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('description'); // Add flag with default as false
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
};
