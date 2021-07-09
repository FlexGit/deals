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
            $table->integer('contractor_id');
			$table->text('data_json')->default('');
			$table->timestamp('deal_date')->useCurrent();
			$table->enum('deal_type', ['buy', 'sell']);
			$table->integer('created_by');
			$table->integer('updated_by');
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
