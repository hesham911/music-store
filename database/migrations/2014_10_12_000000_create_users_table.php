<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\UserTypes;
use App\Enum\UserStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->boolean('is_admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->enum('type',[
                UserTypes::Collaborator,
                UserTypes::Artist,
                UserTypes::Visitor,
                UserTypes::Admin
            ])->default(UserTypes::Visitor);

            $table->enum('status',[
                UserStatus::Active, UserStatus::Inactive,
                UserStatus::Blocked,
                UserStatus::Deleted
            ])->default(UserStatus::Active);

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
