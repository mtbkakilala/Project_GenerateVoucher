<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherCode extends Model
{
    protected $table = 'voucher_codes'; // change to 'voucher_code' if that’s your actual table name

    protected $fillable = ['user_id', 'code']; // ✅ allow user_id to be saved
}
