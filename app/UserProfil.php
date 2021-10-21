<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfil extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['avatar', 'apiKey', 'apiSecret', 'currency', 'devise', 'user_id'];

    protected $attributes = [
        'currency' => "XXBT, XETH, XLTC, XXRP",
        'devise' => "EUR"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}