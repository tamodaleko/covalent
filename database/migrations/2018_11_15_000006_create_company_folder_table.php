<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_folder', function (Blueprint $table) {
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('folder_id');

            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('folder_id')->references('id')->on('folders')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['company_id', 'folder_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_folder', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['folder_id']);
        });

        Schema::dropIfExists('company_folder');
    }
}
