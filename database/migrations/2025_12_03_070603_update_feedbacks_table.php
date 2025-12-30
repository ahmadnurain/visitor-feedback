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
        Schema::table('feedbacks', function (Blueprint $table) {
            if (Schema::hasColumn('feedbacks', 'category')) {
                $table->dropColumn('category');
            }

            if (!Schema::hasColumn('feedbacks', 'feedback_category_id')) {
                $table->foreignId('feedback_category_id')->nullable()->constrained('feedback_categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('feedbacks', 'visitor_name')) {
                $table->string('visitor_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('feedbacks', 'channel')) {
                $table->string('channel')->default('web')->after('visitor_name');
            }

            if (Schema::hasColumn('feedbacks', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('feedbacks', function (Blueprint $table) {
            if (!Schema::hasColumn('feedbacks', 'status')) {
                $table->enum('status', ['new', 'processing', 'resolved', 'ignored'])->default('new')->after('attachments');
            }
            if (!Schema::hasColumn('feedbacks', 'action_taken')) {
                $table->text('action_taken')->nullable()->after('status');
            }
            if (!Schema::hasColumn('feedbacks', 'processed_by')) {
                $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete()->after('action_taken');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropForeign(['feedback_category_id']);
            $table->dropForeign(['processed_by']);
            $table->dropColumn(['feedback_category_id', 'visitor_name', 'channel', 'action_taken', 'processed_by', 'status']);
        });

        Schema::table('feedbacks', function (Blueprint $table) {
            $table->enum('category', ['keluhan', 'saran', 'apresiasi'])->after('user_id');
            $table->enum('status', ['baru', 'diproses', 'selesai', 'ditolak'])->default('baru')->after('attachments');
        });
    }
};
