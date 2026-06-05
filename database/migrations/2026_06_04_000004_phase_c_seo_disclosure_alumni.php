<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('default_meta_description')->nullable()->after('tagline');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('title');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('title');
            $table->string('meta_description', 500)->nullable()->after('meta_title');
        });

        Schema::create('disclosure_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('pdf_path');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('alumni_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('batch_year', 10)->nullable();
            $table->string('current_occupation')->nullable();
            $table->text('message')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_registrations');
        Schema::dropIfExists('disclosure_documents');

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('default_meta_description');
        });
    }
};
