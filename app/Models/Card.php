<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'expiryDate',
        'cvv',
        'vcc_id',
        'bin',
        'binId',
        'organization',
        'state',
        'remark',
        'createTime',
        'modifyTime',
        'cardBalance',
        'adapterSign',

        'totalConsume',
        'totalRefund',
        'totalRecharge',
        'totalCashOut',
        'bankCardId',
        'hiddenNum',
        'hiddenCvv',
        'hiddenDate',
        'isHidden',
        'email',
        'type',
        'public_share_token',
    ];

    /**
     * Long, unguessable token for public guest share URLs (hex, 128 chars).
     */
    public static function newShareToken(): string
    {
        return bin2hex(random_bytes(64));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
