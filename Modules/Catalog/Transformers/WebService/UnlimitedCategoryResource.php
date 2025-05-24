<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class UnlimitedCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $childrenRecursive = $this->childrenRecursive->map(function ($item) {
            return $item;
        })->reject(function ($item) {
            return count($item->products) == 0;
        });
        
        $result = [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image ? url($this->image) : null,
            'sub_categories' => UnlimitedCategoryResource::collection($childrenRecursive),
        ];

        if ($request->get_products == 'yes')
            $result['products'] = ProductResource::collection($this->products);

        return $result;
    }
}
