<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailmodel extends Model
{
    use HasFactory;

    protected $table = 'order_detail';
    protected $primarykey = 'id_detail';
    public $timestamps = true;
    public $fillable = [
        'id_order',
        'id_food',
        'quantity',
        'price',
    ];

    public function order_list()
    {
        return $this->hasMany
        (ordermodel::class, 'id_order', 'id_order');
    }

}
