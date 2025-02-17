<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->unique()->after('name');
            $table->enum('role', ['employee', 'admin'])->default('employee')->after('cpf');
            $table->string('position')->nullable()->after('role');
            $table->date('birth_date')->nullable()->after('position');
            $table->string('zip_code')->nullable()->after('birth_date');
            $table->string('address')->nullable()->after('zip_code');
            $table->foreignId('created_by')->nullable()->after('address')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cpf', 'role', 'position', 'birth_date', 'zip_code', 'address']);
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
}
