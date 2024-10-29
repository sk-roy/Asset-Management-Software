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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->nullable();
            $table->dateTime('datetime')->nullable();
            $table->text('description')->nullable();
            $table->float('charge')->nullable();
            $table->boolean('active_mode')->default(true);
            $table->string('map_location')->nullable(); 

            // Additional fields for various event categories
            $table->string('service_provider')->nullable();  // For Service category
            $table->text('service_details')->nullable();     // For Service category
            $table->string('cleaning_service')->nullable();  // For Clean category
            $table->float('cleaning_charge')->nullable();    // For Clean category
            $table->string('replacement_item')->nullable();  // For Replace category
            $table->float('replacement_cost')->nullable();   // For Replace category
            $table->string('visitor_name')->nullable();      // For Visit category
            $table->string('visit_purpose')->nullable();     // For Visit category
            $table->string('bill_provider')->nullable();     // For Bill Payment category
            $table->float('bill_amount')->nullable();        // For Bill Payment category           

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('asset_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
