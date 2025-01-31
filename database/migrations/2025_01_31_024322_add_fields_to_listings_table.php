<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('description');
            $table->decimal('revenue', 10, 2)->nullable()->after('price');
            $table->decimal('profit', 10, 2)->nullable()->after('revenue');

            $table->string('category')->nullable()->after('profit')->index();
            $table->string('location')->nullable()->after('category')->index();
            $table->enum('status', ['active', 'pending', 'sold'])->default('active')->after('location')->index();

            $table->integer('years_in_business')->nullable()->after('status');
            $table->integer('employees')->nullable()->after('years_in_business');
            $table->text('reason_for_selling')->nullable()->after('employees');

            $table->string('contact_email')->nullable()->after('reason_for_selling');
            $table->string('phone_number', 20)->nullable()->after('contact_email');
            $table->string('website')->nullable()->after('phone_number');

            $table->integer('views')->default(0)->after('website')->index();
            $table->boolean('featured')->default(false)->after('views')->index();
            $table->string('video_url')->nullable()->after('featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'revenue',
                'profit',
                'category',
                'location',
                'status',
                'years_in_business',
                'employees',
                'reason_for_selling',
                'contact_email',
                'phone_number',
                'website',
                'views',
                'featured',
                'video_url'
            ]);
        });
    }
};
