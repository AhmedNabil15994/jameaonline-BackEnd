<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Traits\VendorTrait;
use Modules\Vendor\Transformers\WebService\VendorResource;

class OrderResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        $allOrderProducts = $this->orderProducts->mergeRecursive($this->orderVariations);

        $result = [
            'id' => $this->id,
            'total' => $this->total,
            'shipping' => $this->shipping,
            'subtotal' => $this->subtotal,
            'transaction' => $this->transactions->method,
            'order_status' => [
                'code' => $this->orderStatus->code,
                'title' => $this->orderStatus->title,
            ],
            'is_rated' => $this->checkUserRateOrder($this->id),
            'rate' => $this->getOrderRate($this->id),
            'created_at' => date('d-m-Y H:i', strtotime($this->created_at)),
            'notes' => $this->notes,
            'products' => OrderProductResource::collection($allOrderProducts),
        ];

        if (is_null($this->unknownOrderAddress)) {
            $result['address'] = new OrderAddressResource($this->orderAddress);
        } else {
            $result['address'] = new UnknownOrderAddressResource($this->unknownOrderAddress);
        }

        if (!is_null($this->driver)) {
            $result['driver'] = new OrderDriverResource($this->driver);
        } else {
            $result['driver'] = null;
        }

        return $result;
    }
}
