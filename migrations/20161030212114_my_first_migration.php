<?php

use Illuminate\Database\Schema\Blueprint;
use \AppMain\Migration\Migration;

class MyFirstMigration extends Migration
{
    public function up()
    {
        $this->schema->create('payum_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('details')->nullable();
            $table->string('number')->nullable();
            $table->string('description')->nullable();
            $table->string('clientId')->nullable();
            $table->string('clientEmail')->nullable();
            $table->string('totalAmount');
            $table->string('currencyCode');
            $table->timestamps();
        });
        $this->schema->create('payum_tokens', function (Blueprint $table) {
            $table->string('hash')->primary();
            $table->text('details')->nullable();
            $table->string('targetUrl')->nullable();
            $table->string('afterUrl')->nullable();
            $table->string('gatewayName')->nullable();
            $table->timestamps();
        });
        $this->schema->create('payum_gateway_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('config');
            $table->string('factoryName');
            $table->string('gatewayName');
            $table->timestamps();
        });
    }
    public function down()
    {
        $this->schema->drop('payum_payments');
        $this->schema->drop('payum_tokens');
        $this->schema->drop('payum_gateway_configs');
    }
}
