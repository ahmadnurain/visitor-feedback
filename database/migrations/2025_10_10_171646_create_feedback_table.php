<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('category', ['keluhan','saran','apresiasi']);
            $table->tinyInteger('rating')->nullable(); // 1..5, opsional utk 'saran'
            $table->string('title', 150);
            $table->text('content');
            $table->json('attachments')->nullable();
            $table->enum('status', ['baru','diproses','selesai','ditolak'])->default('baru');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('submitted_ip', 45)->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->index(['destination_id', 'status']);
            $table->index('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
