<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'flag' => $this->flag ?? null,
            // 'vendors' => VendorResource::collection($this->whenLoaded('vendors')),
        ];
    }
}
