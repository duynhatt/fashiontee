<?php

namespace Database\Seeders;

use App\Models\BienThe;
use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendingCodOrdersSeeder extends Seeder
{
    /**
     * Seed 20 COD orders in "cho_xac_nhan" status,
     * created in last 7 days excluding today.
     */
    public function run(): void
    {
        $users = User::query()
            ->where('role', '!=', 'admin')
            ->get();

        if ($users->isEmpty()) {
            $users = User::query()->get();
        }

        if ($users->isEmpty()) {
            $this->command?->warn('Khong co user de tao don hang seed.');
            return;
        }

        $variants = BienThe::query()
            ->with('product.danhMuc')
            ->where('trang_thai', 1)
            ->where('so_luong', '>', 0)
            ->whereHas('product', function ($query): void {
                $query->where('trang_thai', 1)
                    ->whereHas('danhMuc', function ($categoryQuery): void {
                        $categoryQuery->where('trang_thai', 1);
                    });
            })
            ->get();

        if ($variants->isEmpty()) {
            $this->command?->warn('Khong co bien the hop le de tao don hang seed.');
            return;
        }

        $createdOrders = 0;
        $maxAttempts = 400;
        $attempt = 0;

        DB::beginTransaction();
        try {
            while ($createdOrders < 20 && $attempt < $maxAttempts) {
                $attempt++;

                $variant = $variants->random();
                $currentStock = (int) $variant->so_luong;

                if ($currentStock < 1 || !$variant->product) {
                    continue;
                }

                $maxQty = min(3, $currentStock);
                $qty = random_int(1, $maxQty);
                $unitPrice = (float) ($variant->gia_khuyen_mai ?? $variant->gia ?? 0);

                if ($unitPrice <= 0) {
                    continue;
                }

                $subtotal = (float) ($unitPrice * $qty);
                $shippingFee = $subtotal >= 1000000 ? 0 : 35000;
                $discount = 0;
                $total = $subtotal + $shippingFee - $discount;

                $user = $users->random();
                $createdAt = Carbon::today()
                    ->subDays(random_int(1, 7))
                    ->setTime(
                        random_int(8, 22),
                        random_int(0, 59),
                        random_int(0, 59)
                    );
                $updatedAt = $createdAt->copy()->addMinutes(random_int(1, 180));

                $order = DonHang::create([
                    'nguoi_dung_id' => $user->id,
                    'dia_chi_id' => null,
                    'voucher_id' => null,
                    'ma_don_hang' => $this->generateUniqueOrderCode(),
                    'tam_tinh' => $subtotal,
                    'tien_giam' => $discount,
                    'phi_van_chuyen' => $shippingFee,
                    'tong_tien' => $total,
                    'phuong_thuc_thanh_toan' => 'cod',
                    'trang_thai_thanh_toan' => 'chua_thanh_toan',
                    'trang_thai' => DonHang::TRANG_THAI_CHO_XAC_NHAN,
                    'dia_chi_chi_tiet' => 'Seed address ' . ($createdOrders + 1),
                    'so_dien_thoai_nhan_hang' => $user->phone ?: '0900000000',
                    'ten_nguoi_nhan' => $user->name ?: 'Khach hang seed',
                    'ghi_chu' => 'Seed don COD cho thong ke admin',
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]);

                ChiTietDonHang::create([
                    'don_hang_id' => $order->id,
                    'san_pham_id' => $variant->san_pham_id,
                    'bien_the_id' => $variant->id,
                    'don_gia' => $unitPrice,
                    'so_luong' => $qty,
                    'thanh_tien' => $subtotal,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]);

                // COD duoc tru ton ngay khi dat hang.
                $variant->decrement('so_luong', $qty);

                $createdOrders++;
            }

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        $this->command?->info("Da tao {$createdOrders} don COD cho_xac_nhan trong 7 ngay gan day (khong gom hom nay).");
    }

    private function generateUniqueOrderCode(): string
    {
        do {
            $code = 'DH' . now()->format('ymd') . strtoupper(Str::random(6));
        } while (DonHang::query()->where('ma_don_hang', $code)->exists());

        return $code;
    }
}

