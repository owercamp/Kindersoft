<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolPeriodToFormsadmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formsadmissions', function (Blueprint $table) {
            $table->string('periodo_escolar',100)->after('migracion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formsadmissions', function (Blueprint $table) {
            $table->dropColumn('periodo_escolar');
        });
    }
}
