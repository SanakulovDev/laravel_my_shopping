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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            // add user_id column
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('description');
            $table->string('logo_url')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone');
            // add address column to text
            $table->text('address');
            //add city column character 100
            $table->string('city', 100);
            $table->string('postal_code', 20);
            $table->string('country', 100);
            //status enum active, inactive, pending
            $table->enum('status', ['active', 'inactive', 'pending']);
            // commission_rate decimal 8,2
            $table->decimal('commission_rate', 5, 2);
            // bank_details
            $table->string('bank_details');
            // tax_id
            $table->string('tax_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
