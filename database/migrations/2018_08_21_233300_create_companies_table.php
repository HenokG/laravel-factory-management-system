<?php

use App\Util\FinalConstants;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();
            $table->integer('owner_tel')->nullable();
            $table->string('manager_name');
            $table->string('manager_email');
            $table->integer('manager_tel');
            $table->enum('status', [FinalConstants::COMPANY_STATUS_APPROVED, FinalConstants::COMPANY_STATUS_SUSPENDED, FinalConstants::COMPANY_STATUS_DELETED])->default(FinalConstants::COMPANY_STATUS_APPROVED);
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
        Schema::dropIfExists('companies');
    }
}
