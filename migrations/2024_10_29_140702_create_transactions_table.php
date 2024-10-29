<?php

use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\Enum\TransactionTypeEnum;
use App\Model\Account;
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('value', 11, 2)->default(0);
            $table->enum('type', TransactionTypeEnum::values());
            $table->enum('status', TransactionStatusEnum::values());
            $table->timestamp('created_at', 0)->nullable();
            $table->string('description');
            $table->foreignUuid('account_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
