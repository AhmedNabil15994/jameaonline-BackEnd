<?php

namespace Modules\Order\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderHistoryStatusResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'flag' => optional($this->orderStatus)->flag,
            'title' => optional($this->orderStatus)->title,
            'color' => optional($this->orderStatus)->color,
        ];
    }
}
