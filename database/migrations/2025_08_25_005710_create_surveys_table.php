<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id(); // Bigint unsigned auto_increment
            $table->string('name', 255);
            $table->timestamps();
            
            // Indexes for performance
            $table->index('created_at');
            $table->index('updated_at');
            
            // Fulltext index for search
            $table->fullText('name');
        });
        
        // Add table comment for documentation
        DB::statement("ALTER TABLE surveys COMMENT = 'Stores survey information, optimized for large datasets'");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
};
