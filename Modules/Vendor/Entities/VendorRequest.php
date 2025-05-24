<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorRequest extends Model
{
    use SoftDeletes;

    protected $table = 'vendor_requests';
    protected $guarded = ['id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
