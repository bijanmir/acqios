<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('listing_views', function (Blueprint $table) {
            $table->id();
            $table->char('listing_id', 36); // Foreign key for the listing
            $table->string('ip_address', 45); // Stores IPv4 or IPv6
            $table->timestamps();

            $table->unique(['listing_id', 'ip_address']); // Ensures unique views per listing
        });
    }

    public function down() {
        Schema::dropIfExists('listing_views');
    }
};
