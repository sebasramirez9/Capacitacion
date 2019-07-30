<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('art_catId')->unsigned();
            $table->string('art_codigo',50)->nullable();
            $table->string('art_name',50)->unique();
            $table->decimal('art_precio_venta',11,2);
            $table->string('art_descripcion',256)->nullable();
            $table->boolean('art_condition')->default(1);
            $table->timestamps();

            $table->foreign('art_catId')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
