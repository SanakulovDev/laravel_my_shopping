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
        // First check if column doesn't exist to avoid "column already exists" error
        if (!Schema::hasColumn('products', 'slug')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('photo');
            });
        }
        
        // Generate unique slugs for existing products
        DB::statement('UPDATE products SET slug = CONCAT("product-", id) WHERE slug IS NULL OR slug = ""');
        
        // Now add the unique constraint separately
        Schema::table('products', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
