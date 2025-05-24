<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryChargeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            // 'id' => $this->id,
            // 'state_id' => $this->state_id,
            'delivery_price' => $this->delivery == 0 || is_null($this->delivery) ? null : $this->delivery,
            'delivery_time' => $this->delivery_time == 0 || is_null($this->delivery_time) ? null : $this->delivery_time,
            'min_order_amount' => $this->min_order_amount == 0 || is_null($this->min_order_amount) ? null : $this->min_order_amount,
        ];
    }
}
