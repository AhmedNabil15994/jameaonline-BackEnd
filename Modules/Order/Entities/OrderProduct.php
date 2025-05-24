<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;

class OrderProduct extends Model
{

    // protected $with 					    = ['product'];

    protected $fillable = [
        'price',
        'sale_price',
        'off',
        'qty',
        'total',
        'original_total',
        'total_profit',
        'notes',
        'add_ons_option_ids',
        'product_id',
        'order_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }


    public function orderVariant()
    {
        return $this->hasOne(OrderVariant::class);
    }
}
