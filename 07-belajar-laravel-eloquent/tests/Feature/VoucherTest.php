<?php

namespace Tests\Feature;

use App\Models\Voucher;
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
}
