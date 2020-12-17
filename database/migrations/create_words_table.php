<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateWordsTable extends Migration
{
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->bigIncrements('word_id');
            $table->text('word');
            $table->integer('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id', 'word'], 'IDX_WORDS01');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('words');
    }
}
