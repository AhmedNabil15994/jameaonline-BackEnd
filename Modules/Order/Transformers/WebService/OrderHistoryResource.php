<?php

namespace Modules\Order\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'flag' => $this->flag,
            'title' => $this->title,
            'color' => $this->color,
        ];
    }
}
