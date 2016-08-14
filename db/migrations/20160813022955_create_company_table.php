<?php

use VueInDepth\Migration\Migration;

class CreateCompanyTable extends Migration
{
    public function up()
    {
        $this->schema->create('companies', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->boolean('active_ind');
            $table->boolean('alive_ind');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('companies');
    }
}