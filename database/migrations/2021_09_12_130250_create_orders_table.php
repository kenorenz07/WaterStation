<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_men');
            $table->json('orders');
            $table->boolean('is_asap')->default(0);
            $table->date('date_to_deliver')->nullable();
            $table->time('time_to_deliver')->nullable();
            $table->float('total', 8, 2);
            $table->enum('status', ['on-the-way','assigned-to-driver', 'pending','delivered','accepted','denied']);
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
        Schema::dropIfExists('orders');
    }
}
