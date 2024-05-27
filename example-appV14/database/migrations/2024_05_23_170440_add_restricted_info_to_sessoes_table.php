<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestrictedInfoToSessoesTable extends Migration
{
    public function up()
    {
        Schema::table('sessoes', function (Blueprint $table) {
            $table->text('restricted_info')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('sessoes', function (Blueprint $table) {
            $table->dropColumn('restricted_info');
        });
    }
}
