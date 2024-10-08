<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'item';

    protected $fillable = [
        'itemName',
        'id',
        'price',
        'stock',
        'image',
        'barcode',
        'status',
        'user_id'
    ];

    public function setStatus()
    {
        if ($this->stock == 0) {
            $this->status = 'outStock';
        } else {
            $this->status = 'inStock';
        }
    }

    public function reduceStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->setStatus();
            $this->save();
            return true;
        }
        return false;
    }

    public function isInStock()
    {
        return $this->stock > 0;
    }

}
