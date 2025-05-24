<?php

namespace Modules\Tags\Entities;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Modules\Core\Traits\ScopesTrait;
use Modules\Catalog\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use Modules\Core\Traits\HasSlugTranslation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasTranslations, SoftDeletes, ScopesTrait;
    use HasSlugTranslation ;

    protected $with = [];
    protected $guarded = ['id'];
    public $translatable = [
        'title' ,"slug"
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags');
    }


}
