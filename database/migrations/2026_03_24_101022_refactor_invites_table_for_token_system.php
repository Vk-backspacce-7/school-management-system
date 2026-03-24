<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('invites')) {
            return;
        }

        try {
            Schema::table('invites', function (Blueprint $table) {
                $table->dropUnique('invites_email_unique');
            });
        } catch (\Throwable $exception) {
            // Index may already be absent.
        }

        Schema::table('invites', function (Blueprint $table) {
            if (Schema::hasColumn('invites', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('invites', 'message')) {
                $table->dropColumn('message');
            }

            if (Schema::hasColumn('invites', 'sent')) {
                $table->dropColumn('sent');
            }

            if (! Schema::hasColumn('invites', 'token')) {
                $table->string('token', 64)->nullable()->after('email');
            }

            if (! Schema::hasColumn('invites', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('token');
            }

            if (! Schema::hasColumn('invites', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable()->after('expires_at');
            }
        });

        DB::table('invites')
            ->whereNull('token')
            ->orderBy('id')
            ->chunkById(100, function ($invites): void {
                foreach ($invites as $invite) {
                    DB::table('invites')
                        ->where('id', $invite->id)
                        ->update(['token' => $this->generateUniqueToken()]);
                }
            });

        try {
            Schema::table('invites', function (Blueprint $table) {
                $table->unique('token');
            });
        } catch (\Throwable $exception) {
            // Index may already exist.
        }

        try {
            Schema::table('invites', function (Blueprint $table) {
                $table->index(['email', 'accepted_at'], 'invites_email_accepted_at_index');
            });
        } catch (\Throwable $exception) {
            // Index may already exist.
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('invites')) {
            return;
        }

        try {
            Schema::table('invites', function (Blueprint $table) {
                $table->dropIndex('invites_email_accepted_at_index');
            });
        } catch (\Throwable $exception) {
            // Index may already be absent.
        }

        try {
            Schema::table('invites', function (Blueprint $table) {
                $table->dropUnique('invites_token_unique');
            });
        } catch (\Throwable $exception) {
            // Index may already be absent.
        }

        Schema::table('invites', function (Blueprint $table) {
            if (Schema::hasColumn('invites', 'token')) {
                $table->dropColumn('token');
            }

            if (Schema::hasColumn('invites', 'expires_at')) {
                $table->dropColumn('expires_at');
            }

            if (Schema::hasColumn('invites', 'accepted_at')) {
                $table->dropColumn('accepted_at');
            }

            if (! Schema::hasColumn('invites', 'name')) {
                $table->string('name')->nullable()->after('id');
            }

            if (! Schema::hasColumn('invites', 'message')) {
                $table->text('message')->nullable()->after('email');
            }

            if (! Schema::hasColumn('invites', 'sent')) {
                $table->boolean('sent')->default(false)->after('message');
            }
        });

        try {
            Schema::table('invites', function (Blueprint $table) {
                $table->unique('email');
            });
        } catch (\Throwable $exception) {
            // Index may already exist.
        }
    }

    private function generateUniqueToken(): string
    {
        do {
            $token = Str::random(64);
        } while (DB::table('invites')->where('token', $token)->exists());

        return $token;
    }
};
