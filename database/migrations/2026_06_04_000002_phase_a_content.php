<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('affiliation_line')->nullable()->after('tagline');
            $table->text('about_text')->nullable()->after('affiliation_line');
            $table->string('mission_title')->nullable()->after('about_text');
            $table->text('mission_text')->nullable();
            $table->string('mission_page_slug')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_text')->nullable();
            $table->string('vision_page_slug')->nullable();
            $table->string('careers_url')->nullable();
            $table->string('mandatory_disclosure_url')->nullable();
            $table->string('fee_payment_url')->nullable();
        });

        Schema::create('desk_messages', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // principal, chairman
            $table->string('name');
            $table->string('designation')->nullable();
            $table->text('message');
            $table->string('photo_path')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('author_name');
            $table->string('author_label')->nullable();
            $table->text('quote');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('desk_messages');

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'affiliation_line',
                'about_text',
                'mission_title',
                'mission_text',
                'mission_page_slug',
                'vision_title',
                'vision_text',
                'vision_page_slug',
                'careers_url',
                'mandatory_disclosure_url',
                'fee_payment_url',
            ]);
        });
    }
};
