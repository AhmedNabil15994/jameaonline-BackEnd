<?php

namespace Modules\Cart\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Traits\VendorTrait;

class CartVendorResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => !is_null($this->image) ? url($this->image) : null,
            'title' => $this->title,
            'payment_methods' => $this->payment_methods ?? [],
            'working_hours' => $this->working_hours ?? null,
        ];
    }
}
