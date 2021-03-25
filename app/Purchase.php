<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'musics_purchases';

    public function music()
    {
        return $this->hasOne(Music::class, 'id', 'music_id');
    }

    public function purchase_token()
    {
        return $this->hasOne(PurchaseToken::class, 'id', 'token_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
