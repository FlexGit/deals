<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
			$table->text('data_json')->nullable();
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
        Schema::dropIfExists('contractors');
    }
}
