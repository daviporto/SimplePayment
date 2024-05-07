<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTransactions extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->float('value', 10, 2);

            $table->unsignedBigInteger('payer_id');
            $table->foreign('payer_id')->references('id')->on('users');

            $table->unsignedBigInteger('payee_id');
            $table->foreign('payee_id')->references('id')->on('users');

            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
