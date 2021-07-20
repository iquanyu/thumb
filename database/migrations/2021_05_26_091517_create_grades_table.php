<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained();
            $table->string('grade_name')->remark('班级名称');
            $table->string('class_name')->remark('年级名称');
            $table->string('teacher')->nullable();
            $table->date('graduate_at')->remark('毕业时间')->nullable();
            $table->integer('class_number')->remark('年级数字');
            $table->integer('grade_number')->remark('班级数字');
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
        Schema::dropIfExists('grades');
    }
}
