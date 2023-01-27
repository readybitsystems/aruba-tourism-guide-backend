<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->string('reset_token')->nullable();
            $table->string('verification_code')->nullable();
            $table->enum('role', [
                User::ROLE_ADMIN,
                user::ROLE_USER,
            ])->default(User::ROLE_USER);
            $table->bigInteger('flags')->default(0);
            $table->timestamps();
            $table->softDeletes();

        });
        
        // insert super admin
        $user                  = new User();
        $user->user_name       = 'admin';
        $user->email           = 'admin@gmail.com';
        $user->password        = 123123;
        $user->role            = User::ROLE_ADMIN;
        $user->addFlag(User::FLAG_ACTIVE);
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
