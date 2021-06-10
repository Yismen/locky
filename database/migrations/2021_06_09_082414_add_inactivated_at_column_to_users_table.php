<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInactivatedAtColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'inactivated_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('inactivated_at')->nullable()->after('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'inactivated_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('inactivated_at');
            });
        }
    }
}
