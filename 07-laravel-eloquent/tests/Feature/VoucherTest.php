<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    public function testCreateVoucher(): void
    {
        $voucher = new Voucher();

        $voucher->name = 'Sample Voucher';
        $voucher->voucher_code = '1231231234'; // 
        $voucher->save();
        Log::info(json_encode($voucher));

        self::assertNotNull($voucher->id);
    }

    public function testCreateVoucherCodeUUID(): void
    {
        $voucher = new Voucher();

        $voucher->name = 'Sample Voucher';
        $voucher->save();
        Log::info(json_encode($voucher));

        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);
    }

    public function testSoftDelete(): void
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        $voucher->delete();

        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        self::assertNull($voucher);

        $voucher = Voucher::withTrashed()->where('name', '=', 'Sample Voucher')->first();
        self::assertNotNull($voucher);
    }

    public function testLocalScope(): void
    {
        $voucher = new Voucher();
        $voucher->name = 'Sample Voucher';
        $voucher->is_active = true;
        $voucher->save();

        $total = Voucher::active()->count();
        self::assertEquals(1, $total);

        $total = Voucher::nonActive()->count();
        self::assertEquals(0, $total);
    }
}
