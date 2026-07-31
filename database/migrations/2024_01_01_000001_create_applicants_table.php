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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('applicant_type', 30); // abuyognon | acc_student | non_abuyognon
            $table->string('last_name', 100);
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('suffix', 20)->nullable();
            $table->string('place_of_examination', 150);
            $table->string('email', 150)->nullable();
            $table->string('contact_number', 20);
            $table->string('identification_path')->nullable();
            $table->boolean('consent_given')->default(false);
            $table->string('ip_address', 45)->nullable();

            // Verification fields
            $table->string('verification_status', 20)->default('pending'); // pending | verified | rejected
            $table->string('id_status', 20)->default('uploaded'); // uploaded | missing | needs_review
            $table->string('verified_by', 100)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index('applicant_type');
            $table->index('verification_status');
            $table->index('id_status');
            $table->index('last_name');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
