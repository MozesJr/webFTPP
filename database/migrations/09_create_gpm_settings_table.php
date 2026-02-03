<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gpm_settings', function (Blueprint $table) {
            $table->id();
            
            // Key-Value Storage
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, json, boolean, integer
            $table->string('group')->nullable(); // edom, survey, dokumen, general
            
            // Description
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            
            // Access Control
            $table->boolean('is_public')->default(false);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('key');
            $table->index('group');
        });
        
        // Insert default settings
        DB::table('gpm_settings')->insert([
            [
                'key' => 'edom_auto_close',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'edom',
                'label' => 'Auto Close EDOM Period',
                'description' => 'Automatically close EDOM period after end date',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'survey_require_login',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'survey',
                'label' => 'Require Login for Surveys',
                'description' => 'Require users to login before filling surveys',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'dokumen_max_size',
                'value' => '10240',
                'type' => 'integer',
                'group' => 'dokumen',
                'label' => 'Maximum Document Size (KB)',
                'description' => 'Maximum file size for document upload',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'gpm_contact_email',
                'value' => 'gpm@ftpp.unipa.ac.id',
                'type' => 'string',
                'group' => 'general',
                'label' => 'GPM Contact Email',
                'description' => 'Email contact for GPM inquiries',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpm_settings');
    }
};
