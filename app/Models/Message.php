<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Message extends Model
{
    protected $connection = 'mongodb';
    protected $collection='WIADOMOSCI';
    protected $fillable = ['wiadomosc','odbiorca_id','nadawca_id','typ_odbiorcy','plik_id'];

}
