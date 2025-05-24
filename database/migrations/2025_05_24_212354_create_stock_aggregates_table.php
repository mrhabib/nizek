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
        Schema::create('stock_aggregates', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('period'); // 1D, 1M, etc.
            $table->float('start_value');
            $table->float('end_value');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
            $table->unique(['company_name', 'period']); // Ensure unique summary
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_aggregates');
    }
};
