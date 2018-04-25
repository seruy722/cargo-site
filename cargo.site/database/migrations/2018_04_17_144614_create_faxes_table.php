<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number_bag')->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('count_place')->nullable();
            $table->integer('kg')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('inventory')->nullable();
            $table->integer('count_sings')->nullable();
            $table->string('code_place')->nullable();
            $table->boolean('barnd')->default(false);
            $table->string('fax_name')->nullable();
            $table->string('notation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faxes', function (Blueprint $table) {
            $table->dropForeign('faxes_client_id_foreign');
        });
        Schema::dropIfExists('faxes');
    }
}
