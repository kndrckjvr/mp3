<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseToken extends Model
{
    protected $table = 'purchase_tokens';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pin',
    ];
}
