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
        Schema::table('expense_purpose', function (Blueprint $table) {
            $table
                ->foreign('purpose_id')
                ->references('id')
                ->on('purposes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('expense_id')
                ->references('id')
                ->on('expenses')
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
        Schema::table('expense_purpose', function (Blueprint $table) {
            $table->dropForeign(['purpose_id']);
            $table->dropForeign(['expense_id']);
        });
    }
};
