<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mapi\Easyapi\Models\ApiModel;

class Products extends ApiModel
{
    protected $allowedRelationsToLoad=[
    ];
    use HasFactory;

    protected $table = 'products';
    protected $fillable = ['title', 'description', 'price','image'];


}
