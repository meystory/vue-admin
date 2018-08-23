<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if(!Schema::hasTable('department'))
        {
            Schema::create('department', function (Blueprint $table) {
                $table->increments('department_id');
                $table->string('name',10)->comment('部门名称');
                $table->integer('parent_id')->unsigned()->default(0)->comment('父级id');
                $table->integer('creator')->unsigned()->default(0)->index()->comment('创建者id');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('department');
    }
}
