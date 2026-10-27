<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participant', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->unique()->after('id')
                ->constrained('users')->cascadeOnDelete();
            $table->string('address')->nullable()->after('name');
            $table->string('phone', 30)->nullable()->after('address');
        });

        Schema::table('trainer', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->unique()->after('id')
                ->constrained('users')->cascadeOnDelete();
            $table->string('phone', 30)->nullable()->after('name');
        });

        Schema::table('lesson', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('lesson', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::table('trainer', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('phone');
        });

        Schema::table('participant', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['address', 'phone']);
        });
    }
};
