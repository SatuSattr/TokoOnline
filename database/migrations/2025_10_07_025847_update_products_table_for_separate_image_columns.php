<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the columns already exist to avoid duplicate error
        if (!Schema::hasColumn('products', 'image2')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('image2')->nullable();
            });
        }
        
        if (!Schema::hasColumn('products', 'image3')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('image3')->nullable();
            });
        }
        
        if (!Schema::hasColumn('products', 'image4')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('image4')->nullable();
            });
        }
        
        if (!Schema::hasColumn('products', 'image5')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('image5')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image2', 'image3', 'image4', 'image5']);
            $table->string('image')->nullable(true)->change();
        });
    }
};
