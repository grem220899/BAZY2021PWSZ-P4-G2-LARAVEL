<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Files extends Model
{
    protected $connection = 'mongodb';
    protected $collection='PLIKI';
    protected $fillable = ['nazwa','rozszerzenie','przeznaczenie','uzytkownik_id'];

}
