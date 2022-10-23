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
        Schema::create('executeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('cost');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('expense_id');
            $table->unsignedBigInteger('type_id');

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
        Schema::dropIfExists('executeds');
    }
};
