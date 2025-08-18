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
        Schema::create('khs_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khs_file_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('parent_models')->onDelete('set null');

            $table->string('access_type')->default('view'); // view, download, preview
            $table->timestamp('accessed_at');
            $table->text('user_agent')->nullable();
            $table->string('ip_address')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['khs_file_id', 'accessed_at']);
            $table->index('parent_id');
            $table->index('accessed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khs_access_logs');
    }
};
