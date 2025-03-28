<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDarkModeToUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'dark_mode')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('dark_mode')->default(false);
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('dark_mode');
        });
    }
}
