<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjaminan_mutus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id')->constrained('program_studis')->onDelete('cascade');
            $table->enum('document_type', ['borang_akreditasi', 'evaluasi_diri', 'sop', 'panduan', 'laporan_penjaminan_mutu']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('document_url', 500)->nullable();
            $table->string('version', 20)->nullable();
            $table->date('effective_date')->nullable();
            $table->date('review_date')->nullable();
            $table->enum('status', ['draft', 'active', 'obsolete'])->default('draft');
            $table->string('created_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjaminan_mutus');
    }
};
