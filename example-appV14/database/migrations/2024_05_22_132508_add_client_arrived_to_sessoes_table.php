<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientArrivedToSessoesTable extends Migration
{
    public function up()
    {
        Schema::table('sessoes', function (Blueprint $table) {
            $table->boolean('client_arrived')->default(false);
        });
    }

    public function down()
    {
        Schema::table('sessoes', function (Blueprint $table) {
            $table->dropColumn('client_arrived');
        });
    }
}
