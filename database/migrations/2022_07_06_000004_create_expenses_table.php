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
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->date('date_to')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('cluster_id');
            $table->unsignedBigInteger('assign_id');
            $table->float('budget');
            $table->unsignedBigInteger('account_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
