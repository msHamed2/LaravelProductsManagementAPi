<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mapi\Easyapi\Models\ApiModel;

class Notification extends ApiModel
{
    use HasFactory;
    protected $table='notification';
    protected $fillable=['title','description','toFcm','status'];
}
