<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('mission_vision_page_slug')->nullable()->after('vision_text');
        });

        if (Schema::hasColumn('site_settings', 'mission_page_slug')) {
            foreach (DB::table('site_settings')->get() as $row) {
                $slug = $row->mission_page_slug ?: ($row->vision_page_slug ?? null);
                if ($slug) {
                    DB::table('site_settings')->where('id', $row->id)->update([
                        'mission_vision_page_slug' => $slug,
                    ]);
                }
            }

            Schema::table('site_settings', function (Blueprint $table) {
                $table->dropColumn(['mission_page_slug', 'vision_page_slug']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('mission_page_slug')->nullable()->after('mission_text');
            $table->string('vision_page_slug')->nullable()->after('vision_text');
        });

        foreach (DB::table('site_settings')->get() as $row) {
            if (! empty($row->mission_vision_page_slug)) {
                DB::table('site_settings')->where('id', $row->id)->update([
                    'mission_page_slug' => $row->mission_vision_page_slug,
                    'vision_page_slug' => $row->mission_vision_page_slug,
                ]);
            }
        }

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('mission_vision_page_slug');
        });
    }
};
