<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('target')->default('_self')->after('link');
            $table->string('icon')->nullable()->after('target');
            $table->boolean('status')->default(1)->after('icon');
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['target', 'icon', 'status']);
        });
    }
};
