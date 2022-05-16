<?php

use App\Models\Language;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Language::class)->nullable()->constrained();
            $table->foreignIdFor(Role::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_language_id_foreign');
            $table->dropForeign('users_role_id_foreign');
            $table->dropColumn('language_id');
            $table->dropColumn('role_id');
        });
    }
};
