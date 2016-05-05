<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string password
 * @property mixed id
 * @property string authCode
 * @property string number
 * @property int isOther
 */
class Tuser extends Model
{
    protected $fillable = ['username'];
}
