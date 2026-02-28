<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah file_path dari varchar -> jsonb
        DB::statement('
            ALTER TABLE designs
            ALTER COLUMN file_path
            TYPE jsonb
            USING to_jsonb(file_path)
        ');

        // Optional: allow null
        DB::statement('
            ALTER TABLE designs
            ALTER COLUMN file_path DROP NOT NULL
        ');
    }

    public function down(): void
    {
        DB::statement('
            ALTER TABLE designs
            ALTER COLUMN file_path
            TYPE varchar(255)
            USING file_path::text
        ');
    }
};