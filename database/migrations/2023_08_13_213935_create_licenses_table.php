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
        if (!Schema::hasTable('licenses')) {
            Schema::create('licenses', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(\App\Models\Company::class, 'company_id')->constrained();
                $table->string('title');
                $table->string('license_link');
                $table->date('issued_date');
                $table->date('expiry_date');
                $table->boolean('is_active');
                $table->string('previous_payment_prove')->nullable();
                $table->string('slug')->unique();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
