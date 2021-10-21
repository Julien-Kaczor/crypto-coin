<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoMoney extends Model
{
    protected $table = 'crypto_money';
    protected $fillable = ['name_crypto', 'name_pair'];
}