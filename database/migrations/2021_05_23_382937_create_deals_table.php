<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->integer('contractor_id')->default(0)->index();
			$table->integer('passport_id')->default(0)->index();
			$table->text('data_json')->nullable();
			$table->timestamp('deal_date')->useCurrent();
			$table->enum('deal_type', ['buy', 'sell'])->nullable()->index();
			$table->integer('created_by')->default(0)->index();
			$table->integer('updated_by')->default(0)->index();
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('deals');
    }
}
