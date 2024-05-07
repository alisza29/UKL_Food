<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ordermodel extends Model
{
    use HasFactory;

    protected $table = 'order_list';
    protected $primarykey = 'id_order';
    public $timestamps = true;
    public $fillable = [
        'name',
        'table_number',
        'order_date',
    ];

    public function order_detail()
    {
        return $this->hasMany
        (detailmodel::class, 'id_order', 'id_order');
    }
}
