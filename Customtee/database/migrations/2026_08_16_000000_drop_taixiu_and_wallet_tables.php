<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('taixiu_bets');
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('game_rounds');
        Schema::dropIfExists('taixiu_settings');

        if (Schema::hasColumn('users', 'wallet_balance')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('wallet_balance');
            });
        }
    }

    public function down(): void
    {
        // Intentionally empty — gambling features were removed.
    }
};
