<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_user', function (Blueprint $table) {
            $table->unsignedBigInteger(tenancy()->tenantModel()->getForeignKey())->index();
            $table->unsignedBigInteger(tenancy()->tenantUserModel()->getForeignKey())->index();
            $table->timestamps();

            $table->primary([
                tenancy()->tenantModel()->getForeignKey(),
                tenancy()->tenantUserModel()->getForeignKey()
            ]);

            $table->foreign(tenancy()->tenantModel()->getForeignKey())
                ->references('id')
                ->on(tenancy()->tenantModel()->getTable())
                ->onDelete('cascade');
            $table->foreign(tenancy()->tenantUserModel()->getForeignKey())
                ->references('id')
                ->on(tenancy()->tenantUserModel()->getTable())
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_user');
    }
}
