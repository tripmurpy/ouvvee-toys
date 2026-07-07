<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('wishlists', 'updated_at')) {
            Schema::table('wishlists', function (Blueprint $table): void {
                $table->timestampTz('updated_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('wishlists', 'updated_at')) {
            Schema::table('wishlists', function (Blueprint $table): void {
                $table->dropColumn('updated_at');
            });
        }
    }
};
