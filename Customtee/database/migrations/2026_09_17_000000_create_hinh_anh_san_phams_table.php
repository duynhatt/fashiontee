<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('hinh_anh_san_phams')) {
            Schema::create('hinh_anh_san_phams', function (Blueprint $table) {
                $table->id();
                $table->foreignId('san_pham_id')->constrained('san_phams')->cascadeOnDelete();
                $table->foreignId('mau_sac_id')->nullable()->constrained('mau_sacs')->nullOnDelete();
                $table->foreignId('bien_the_id')->nullable()->constrained('bien_thes')->cascadeOnDelete();
                $table->string('duong_dan');
                $table->unsignedInteger('thu_tu')->default(0);
                $table->timestamps();
                $table->index(['san_pham_id', 'mau_sac_id']);
                $table->index(['san_pham_id', 'bien_the_id']);
            });

            return;
        }

        Schema::table('hinh_anh_san_phams', function (Blueprint $table) {
            if (!Schema::hasColumn('hinh_anh_san_phams', 'bien_the_id')) {
                $table->foreignId('bien_the_id')->nullable()->after('mau_sac_id')->constrained('bien_thes')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('hinh_anh_san_phams', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('hinh_anh_san_phams', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hinh_anh_san_phams');
    }
};
