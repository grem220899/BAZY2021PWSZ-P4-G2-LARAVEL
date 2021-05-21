<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Zamienniki extends Model
{
    protected $connection = 'mongodb';
    protected $collection='ZAMIENNIKI';
    protected $fillable = ['nazwa','aktywny'];

}
