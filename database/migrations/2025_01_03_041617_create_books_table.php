<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;             // ← Add this!

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('book_name');
    $table->string('author');
    $table->longText('text');

    // instead of foreignIdFor(User::class):
    $table->unsignedBigInteger('user_id');
    $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->cascadeOnDelete();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
