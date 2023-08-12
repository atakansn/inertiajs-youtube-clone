<?php

use App\Enums\VideoPublished;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->ulid('id');
            $table->ulid('channel_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->bigInteger('view_count')->default(0);
            $table->bigInteger('duration')->default(0);
            $table->boolean('is_published')->default(VideoPublished::UNPUBLISHED->value);
            $table->integer('processing_percentage')->default(0)->nullable();
            $table->string('raw_file_path')->nullable();
            $table->string('processed_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
