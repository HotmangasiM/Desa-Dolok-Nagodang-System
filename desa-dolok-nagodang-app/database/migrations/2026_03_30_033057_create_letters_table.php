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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->nullable();

            $table->foreignId('letter_type_id')->constrained('letter_types')->cascadeOnDelete();
            $table->string('applicant_national_id', 16);

            $table->timestamp('submission_date')->nullable();
            $table->timestamp('verification_date')->nullable();
            $table->timestamp('approval_date')->nullable();

            $table->enum('status', ['SUBMITTED', 'PROCESSING', 'REJECTED', 'COMPLETED'])
                ->default('SUBMITTED');

            $table->text('notes')->nullable();
            $table->string('result_file')->nullable();

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // FK ke citizens (manual karena bukan id)
            $table->foreign('applicant_national_id')
                ->references('nik')
                ->on('citizens')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
