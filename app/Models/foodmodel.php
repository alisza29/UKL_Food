<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foodmodel extends Model
{
    use HasFactory;
    
    protected $table = 'food';
    protected $primarykey = 'id_food';
    public $timestamps = true;
    public $fillable = [
        'name',
        'spicy_level',
        'price',
        'image',
    ];
    
}
