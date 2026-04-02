<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (! Schema::hasColumn('messages', 'is_seen')) {
                $table->boolean('is_seen')->default(false)->after('message');
            }

            $table->index(['receiver_id', 'is_seen']);
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['receiver_id', 'is_seen']);

            if (Schema::hasColumn('messages', 'is_seen')) {
                $table->dropColumn('is_seen');
            }
        });
    }
};
