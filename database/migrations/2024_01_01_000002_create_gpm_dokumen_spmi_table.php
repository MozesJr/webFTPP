<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Table: gpm_dokumen_spmi
     * Purpose: Menyimpan dokumen Sistem Penjaminan Mutu Internal
     */
    public function up(): void
    {
        Schema::create('gpm_dokumen_spmi', function (Blueprint $table) {
            $table->id();
            
            // Document Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Category
            $table->enum('category', ['standar', 'manual', 'formulir', 'sop'])
                  ->default('standar');
            
            // File Information
            $table->string('file_path'); // storage path
            $table->string('file_name'); // original filename
            $table->bigInteger('file_size')->default(0); // in bytes
            $table->string('file_type', 50)->default('pdf'); // pdf, doc, docx, xls, xlsx
            
            // Metadata
            $table->string('document_code')->nullable(); // kode dokumen, e.g., SPMI-001
            $table->string('version', 20)->nullable(); // versi dokumen, e.g., 1.0
            $table->date('published_date')->nullable();
            $table->date('effective_date')->nullable(); // tanggal berlaku
            $table->date('review_date')->nullable(); // tanggal review berikutnya
            
            // Statistics
            $table->integer('download_count')->default(0);
            $table->integer('view_count')->default(0);
            
            // Publishing
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            
            // Relations
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('category');
            $table->index('is_published');
            $table->index('published_date');
            $table->index('document_code');
            $table->fullText(['title', 'description']); // for better search
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_dokumen_spmi');
    }
};
