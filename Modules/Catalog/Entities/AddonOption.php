<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Translatable\HasTranslations;

class AddonOption extends Model
{
    use HasTranslations, ScopesTrait, SoftDeletes;

    protected $table = 'addon_options';
    protected $with = [];
    protected $guarded = ["id"];
    public $translatable = ['title'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
    
    public function addonCategory()
    {
        return $this->belongsTo(AddonCategory::class, 'addon_category_id');
    }
}
