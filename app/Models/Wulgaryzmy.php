<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Wulgaryzmy extends Model
{
    protected $connection = 'mongodb';
    protected $collection='WULGARYZMY';
    protected $fillable = ['nazwa','aktywny'];

}
