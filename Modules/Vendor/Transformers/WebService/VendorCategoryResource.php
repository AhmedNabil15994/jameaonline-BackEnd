<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image ? url($this->image) : null,
            'cover' => $this->cover ? url($this->cover) : null,
            'color' => $this->color ?? null,
            // 'sort' => $this->sort ?? null,
            'vendors' => SimpleRestaurantVendorResource::collection($this->vendors),
            'vendor_sub_categories' => VendorCategoryResource::collection($this->childrenRecursive),
        ];
    }
}
