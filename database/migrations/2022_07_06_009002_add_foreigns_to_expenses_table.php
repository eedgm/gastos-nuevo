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
        Schema::table('expenses', function (Blueprint $table) {
            $table
                ->foreign('cluster_id')
                ->references('id')
                ->on('clusters')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('assign_id')
                ->references('id')
                ->on('assigns')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('account_id')
                ->references('id')
                ->on('accounts')
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
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['cluster_id']);
            $table->dropForeign(['assign_id']);
            $table->dropForeign(['account_id']);
        });
    }
};
