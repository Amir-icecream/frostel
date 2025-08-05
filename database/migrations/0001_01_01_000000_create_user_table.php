<?php
namespace Database;

use Core\Database\Schema;
use Core\Database\BluePrint;
use Core\Database\Migration;

return new class extends Migration{
    public function up(){
        Schema::create('users',function(BluePrint $table){
            $table->id();
            $table->string('username',255)->notNull()->unique();
            $table->string('password',255)->notNull();
            $table->string('number',11)->nullable()->unique();
            $table->string('email',254)->nullable()->unique();
            $table->string('role',20)->notNull()->default("user");
            $table->string('remember_token',100)->notNull()->unique();
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('users');
    }
};