<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->after('name', function ($table) {
                $table->tinyText('group')->nullable();
                $table->enum('role', ['superadmin', 'admin','team','user'])->default('user')->nullable();
                $table->tinyText('tariff')->nullable();
                $table->unsignedDecimal('balance', $precision = 8, $scale = 2)->default(0)->nullable();
                $table->string('description', 1024)->nullable();
            });            
            $table->ipAddress('last_ip')->nullable();
            $table->date('expire')->nullable();
            $table->datetime('last_login', $precision = 0)->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('group');
            $table->dropColumn('tariff');
            $table->dropColumn('description');
            $table->dropColumn('last_ip');
            $table->dropColumn('balance');
            $table->dropColumn('expire');
            $table->dropColumn('last_login');
        });
    }
};
