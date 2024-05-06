<?php

use App\Domain\User\UserTypeEnum;
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('cpf', 11)->unique();
            $table->enum('type', [UserTypeEnum::Customer->value, UserTypeEnum::Retailer->value]);

            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
