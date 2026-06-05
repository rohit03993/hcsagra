<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('admin')->after('email');
        });

        DB::table('users')->update(['role' => 'admin']);

        Schema::create('admission_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('parent_name');
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->string('class_applying', 50);
            $table->text('message')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admission_enquiries');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
