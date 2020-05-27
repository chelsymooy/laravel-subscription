<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id');
            $table->string('name')->default('default');
            $table->double('price');
            $table->double('discount')->default(0);
            //RECURRING
            $table->string('recurring_opt');
            $table->bigInteger('recurring_val');
            //DEFAULT PENALTY
            $table->double('penalty_rate');
            $table->string('penalty_period_opt');
            $table->smallInteger('penalty_period_val');
            //ACTIVE PERIOD
            $table->datetime('started_at');
            $table->datetime('ended_at')->nullable();
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
        Schema::dropIfExists('plan_prices');
    }
}
