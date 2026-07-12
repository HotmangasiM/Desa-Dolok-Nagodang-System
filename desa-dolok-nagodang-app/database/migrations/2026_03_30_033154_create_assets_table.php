<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_code')->unique();
            $table->string('category')->nullable();

            $table->integer('quantity')->default(0);
            $table->enum('condition', ['good', 'damaged'])->default('good');

            $table->string('location')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->string('source')->nullable();

            $table->decimal('asset_value', 15, 2)->nullable();
            $table->string('asset_photo')->nullable();

            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};