<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('san_phams', function (Blueprint $table) {
            $table->string('chat_lieu', 255)->nullable()->after('mo_ta_chi_tiet');
            $table->string('kieu_dang', 255)->nullable()->after('chat_lieu');
            $table->text('diem_noi_bat')->nullable()->after('kieu_dang');
            $table->text('huong_dan_bao_quan')->nullable()->after('diem_noi_bat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('san_phams', function (Blueprint $table) {
            $table->dropColumn(['chat_lieu', 'kieu_dang', 'diem_noi_bat', 'huong_dan_bao_quan']);
        });
    }
};
