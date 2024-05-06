<?php

use App\Domain\Wallet\WalletStatusEnum;
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateTableWallet extends Migration
{
    public function up(): void
    {
        Schema::create('wallet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('balance', 10, 2);
            $table->enum('status', [
                WalletStatusEnum::ACTIVE->value,
                WalletStatusEnum::PENDING->value,
                WalletStatusEnum::BLOCKED->value,
            ]);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet');
    }
}
