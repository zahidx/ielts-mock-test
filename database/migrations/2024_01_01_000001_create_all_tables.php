<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); $table->string('user_id')->unique(); $table->string('name');
            $table->string('password'); $table->boolean('is_admin')->default(false); $table->timestamps();
        });
        Schema::create('tests', function (Blueprint $table) {
            $table->id(); $table->string('title'); $table->text('description')->nullable();
            $table->boolean('is_active')->default(true); $table->timestamps();
        });
        Schema::create('sections', function (Blueprint $table) {
            $table->id(); $table->foreignId('test_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['listening','reading','writing','speaking']); $table->string('title');
            $table->integer('duration_minutes'); $table->integer('order');
            $table->longText('content')->nullable(); $table->longText('content_extra')->nullable(); $table->timestamps();
        });
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->integer('question_number'); $table->text('question_text');
            $table->enum('question_type', ['mcq','true_false_ng','fill_blank','matching','short_answer']);
            $table->string('correct_answer')->nullable(); $table->string('group_label')->nullable();
            $table->integer('order'); $table->timestamps();
        });
        Schema::create('options', function (Blueprint $table) {
            $table->id(); $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->string('label'); $table->text('option_text'); $table->timestamps();
        });
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('test_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['in_progress','completed'])->default('in_progress');
            $table->string('current_section')->nullable(); $table->timestamps();
        });
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); $table->foreignId('test_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('answer_text')->nullable(); $table->boolean('is_correct')->nullable(); $table->timestamps();
        });
        Schema::create('results', function (Blueprint $table) {
            $table->id(); $table->foreignId('test_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->integer('correct_count')->default(0); $table->integer('total_questions')->default(0);
            $table->decimal('band_score', 3, 1)->nullable(); $table->timestamps();
        });
        Schema::create('writing_submissions', function (Blueprint $table) {
            $table->id(); $table->foreignId('test_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->longText('task1_response')->nullable(); $table->integer('task1_word_count')->default(0);
            $table->longText('task2_response')->nullable(); $table->integer('task2_word_count')->default(0);
            $table->decimal('band_score', 3, 1)->nullable(); $table->text('admin_feedback')->nullable(); $table->timestamps();
        });
        Schema::create('recordings', function (Blueprint $table) {
            $table->id(); $table->foreignId('test_attempt_id')->constrained()->onDelete('cascade');
            $table->string('file_path'); $table->integer('duration_seconds')->nullable();
            $table->decimal('band_score', 3, 1)->nullable(); $table->text('admin_feedback')->nullable(); $table->timestamps();
        });
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable(); $table->text('user_agent')->nullable();
            $table->longText('payload'); $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        foreach (['sessions','recordings','writing_submissions','results','answers','test_attempts','options','questions','sections','tests','users'] as $t)
            Schema::dropIfExists($t);
    }
};
