<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCarterColumnsToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('shopify_id')->nullable();
            $table->string('shopify_domain')->nullable();
            $table->string('plan')->nullable();
            $table->unsignedBigInteger('shopify_charge_id')->nullable();
            $table->string('shopify_token')->nullable();
            $table->string('shopify_scope')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(
                'shopify_id',
                'shopify_domain',
                'shopify_charge_id',
                'shopify_token',
                'shopify_scope'
            );
        });
    }
}
