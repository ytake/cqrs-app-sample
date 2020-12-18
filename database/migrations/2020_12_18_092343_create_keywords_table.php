<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateKeywordsTable extends Migration
{
    public function up(): void
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->bigIncrements('keyword_id');
            $table->char('word', 255);
            $table->integer('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['user_id', 'word'], 'IDX_KEYWORDS01');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
}
