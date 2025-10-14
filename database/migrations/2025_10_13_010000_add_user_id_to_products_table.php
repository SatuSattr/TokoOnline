<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('products', 'user_id')) {
            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('DROP TABLE IF EXISTS "__temp__products"');

            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable();
            });

            // SQLite cannot add foreign keys on existing tables easily; skip FK constraint in this environment.
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('products', 'user_id')) {
            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('DROP TABLE IF EXISTS "__temp__products"');

            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });

            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
