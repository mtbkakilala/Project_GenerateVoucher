<?php

namespace App\Http\Controllers;

use App\Models\VoucherCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherCodeController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->voucherCodes;
    }

    public function generate(Request $request)
    {
        $user = $request->user();

        if ($user->voucherCodes()->count() >= 10) {
            return response()->json(['error' => 'You can only have 10 voucher codes'], 400);
        }

        $code = Str::upper(Str::random(5));
        $voucher = $user->voucherCodes()->create(['code' => $code]);

        return response()->json($voucher, 201);
    }

    public function destroy(Request $request, $id)
    {
        $voucher = $request->user()->voucherCodes()->findOrFail($id);
        $voucher->delete();

        return response()->json(['message' => 'Voucher code deleted']);
    }
}
