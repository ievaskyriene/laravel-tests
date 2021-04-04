<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropNotNullContraintsForReservationDates extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->date('reserved_from')->nullable()->change();
            $table->date('reserved_to')->nullable()->change();
        });
    }
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->date('reserved_from')->nullable(false)->change();
            $table->date('reserved_to')->nullable(false)->change();
        });
    }
}
