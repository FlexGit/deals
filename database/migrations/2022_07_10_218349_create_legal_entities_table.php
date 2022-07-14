<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalEntitiesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('legal_entities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
			$table->string('inn', 50)->nullable();
			$table->string('kpp', 50)->nullable();
			$table->string('ogrn', 50)->nullable();
			$table->string('bank')->nullable();
			$table->string('rs', 50)->nullable();
			$table->string('ks', 50)->nullable();
			$table->string('bik', 50)->nullable();
			$table->string('address')->nullable();
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
        Schema::dropIfExists('legal_entities');
    }
}
