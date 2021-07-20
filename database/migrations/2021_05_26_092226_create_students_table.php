<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained();
            $table->foreignId('grade_id')->nullable()->constrained();
            $table->foreignId('residential_quarter_id')->nullable()->constrained();
            $table->string('username');
            $table->enum('gender', ['m', 'f']);
            $table->date('birthday')->nullable();
            $table->text('remarks')->nullable();
			$table->foreignId('induct_id')->nullable()->constrained();
            $table->softDeletes();
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
        Schema::table('students', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('students');
    }
}
