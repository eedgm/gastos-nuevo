<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('executeds', function (Blueprint $table) {
            $table
                ->foreign('expense_id')
                ->references('id')
                ->on('expenses')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('executeds', function (Blueprint $table) {
            $table->dropForeign(['expense_id']);
            $table->dropForeign(['type_id']);
        });
    }
};
