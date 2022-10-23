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
        Schema::table('account_purpose', function (Blueprint $table) {
            $table
                ->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('purpose_id')
                ->references('id')
                ->on('purposes')
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
        Schema::table('account_purpose', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['purpose_id']);
        });
    }
};
