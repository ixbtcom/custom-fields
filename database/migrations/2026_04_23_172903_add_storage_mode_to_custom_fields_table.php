<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('custom_fields')) {
            return;
        }

        $hasStorageColumn = Schema::hasColumn('custom_fields', 'storage');
        $hasJsonColumn = Schema::hasColumn('custom_fields', 'storage_column');

        if ($hasStorageColumn && $hasJsonColumn) {
            return;
        }

        Schema::table('custom_fields', function (Blueprint $table) {
            if (! Schema::hasColumn('custom_fields', 'storage')) {
                $table->string('storage', 16)->default('schema')->after('customizable_type');
            }

            if (! Schema::hasColumn('custom_fields', 'storage_column')) {
                $table->string('storage_column', 64)->nullable()->after('storage');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('custom_fields')) {
            return;
        }

        $columns = array_values(array_filter([
            Schema::hasColumn('custom_fields', 'storage') ? 'storage' : null,
            Schema::hasColumn('custom_fields', 'storage_column') ? 'storage_column' : null,
        ]));

        if ($columns === []) {
            return;
        }

        Schema::table('custom_fields', function (Blueprint $table) {
            $table->dropColumn($columns);
        });
    }
};
