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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('coupon_id')->nullable()->after('user_id')->constrained()->onDelete('set null');
            $table->foreignId('shipping_method_id')->nullable()->after('coupon_id')->constrained()->onDelete('set null');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('total_amount');
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropForeign(['shipping_method_id']);
            $table->dropColumn(['coupon_id', 'shipping_method_id', 'discount_amount', 'shipping_cost']);
        });
    }
};
