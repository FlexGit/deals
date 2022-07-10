<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('passports', function (Blueprint $table) {
            $table->id();
			$table->integer('contractor_id')->default(0)->index();
            $table->string('series', 25)->nullable();
			$table->string('number', 25)->nullable();
			$table->date('issue_date')->nullable();
			$table->string('issue_office')->nullable();
			$table->integer('zipcode')->default(0);
			$table->string('region')->nullable();
			$table->string('city')->nullable();
			$table->string('street')->nullable();
			$table->string('house', 25)->nullable();
			$table->string('appartment', 25)->nullable();
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
        Schema::dropIfExists('passports');
    }
}
