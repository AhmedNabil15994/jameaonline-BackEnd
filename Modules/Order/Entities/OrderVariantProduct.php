<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderVariantProduct extends Model
{
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
        'product_variant_id',
        'order_id',
    ];

    public function variant()
    {
        return $this->belongsTo(\Modules\Variation\Entities\ProductVariant::class, 'product_variant_id');
    }

    public function orderVariantValues()
    {
        return $this->hasMany(OrderVariantProductValue::class);
    }
}
