<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Area\Entities\State;
use Modules\Company\Entities\Company;
use Modules\Core\Traits\ScopesTrait;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderVendor;

use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;
use Modules\User\Entities\User;

class Vendor extends Model
{
    use HasSlugTranslation;
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $with = [];
    public $translatable = [
        'description', 'title', 'slug', 'seo_description', 'seo_keywords', 'working_hours', 'offer_text', 'direct_delivery_message',
        'address',
    ];
    protected $guarded = ["id"];
    protected $casts = [
        'payment_methods' => 'array',
        'delivery_time_types' => 'array',
        'payment_data' => "array",
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function scopeRestaurant($query)
    {
        return $query->whereHas('section', function ($query) {
            $query->where('flag', 'restaurant');
        });
    }

    public function scopeService($query)
    {
        return $query->whereHas('section', function ($query) {
            $query->where('flag', 'service');
        });
    }

    public function scopeShop($query)
    {
        return $query->whereHas('section', function ($query) {
            $query->where('flag', 'shop');
        });
    }

    public function scopeVendor($query)
    {
        return $query->whereHas('section', function ($query) {
            $query->where('flag', 'vendor');
        });
    }

    public function scopeSorted($query, $order = 'ASC')
    {
        return $query->orderByRaw("
            (CASE
                WHEN
                    vendor_status_id IS NULL THEN 1
                WHEN
                    vendor_status_id = 4 THEN 2
                WHEN
                    vendor_status_id = 3 THEN 3
                ELSE 4
            END) $order");
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'vendor_payments');
    }

    public function openingStatus()
    {
        return $this->belongsTo(VendorStatus::class, 'vendor_status_id');
    }

    public function sellers()
    {
        return $this->belongsToMany(\Modules\User\Entities\User::class, 'vendor_sellers', 'vendor_id', 'seller_id')->withTimestamps();
    }

    /* public function sections()
    {
        return $this->belongsToMany(Section::class, 'vendor_sections');
    } */

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function subbscription()
    {
        return $this->hasOne(\Modules\Subscription\Entities\Subscription::class)->latest();
    }

    public function subscriptionHistory()
    {
        return $this->hasMany(\Modules\Subscription\Entities\SubscriptionHistory::class);
    }

    public function products()
    {
        return $this->hasMany(\Modules\Catalog\Entities\Product::class);
    }

    public function subscribed()
    {
        return $this->subbscription()->active()->unexpired()->started();
    }

    public function rates()
    {
        return $this->hasMany(\Modules\Vendor\Entities\Rate::class, 'vendor_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'vendor_companies');
    }

    public function states()
    {
        return $this->belongsToMany(State::class, 'vendor_states');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_vendors');
    }

    public function categories()
    {
        return $this->belongsToMany(VendorCategory::class, 'vendor_categories_pivot')->withTimestamps();
    }

    public function subCategories()
    {
        return $this->belongsToMany(VendorCategory::class, 'vendor_categories_pivot')
            ->whereNotNull('vendor_categories.vendor_category_id')->withTimestamps();
    }

    public function parentCategories()
    {
        return $this->belongsToMany(VendorCategory::class, 'vendor_categories_pivot')
            ->whereNull('vendor_categories.vendor_category_id')->withTimestamps();
    }

    public function deliveryCharge()
    {
        return $this->hasMany(VendorDeliveryCharge::class, 'vendor_id');
    }

    public function drivers()
    {
        return $this->belongsToMany(User::class, 'vendor_drivers')->withTimestamps();
    }

    public function workTimes()
    {
        return $this->hasMany(VendorWorkTime::class, 'vendor_id');
    }

    public function deliveryTimes()
    {
        return $this->hasMany(VendorDeliveryTime::class, 'vendor_id');
    }
}
