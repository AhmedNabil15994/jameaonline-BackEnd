<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Traits\VendorTrait;

class SimpleRestaurantVendorResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => !is_null($this->image) ? url($this->image) : null,
            'logo' => !is_null($this->logo) ? url($this->logo) : null,
            'title' => $this->title,
            'section' => new SectionResource($this->section),
            'rate' => $this->getVendorRate($this->id),
            'payment_methods' => $this->payment_methods ?? [],
            'working_hours' => $this->working_hours ?? null,
            'offer_text' => $this->offer_text ?? null,

            'address' => $this->address ?? null,
            'mobile' => !is_null($this->mobile) ? /*$this->calling_code .*/ $this->mobile : null,
            'whatsapp' => $this->whatsapp ?? null,

            // 'opening_status' => new OpeningStatusResource($this->openingStatus),
            /*'address' => optional($this->address ?? '',
            'mobile' => !is_null($this->mobile) ? $this->calling_code . $this->mobile : null,*/
        ];

        $result['opening_status'] = $this->checkVendorBusyStatus($this->id);

        if (!is_null($request->state_id)) {
            $deliveryModel = $this->getVendorDeliveryByState($this->id, $request->state_id);
            $result['delivery'] = $deliveryModel ? new DeliveryChargeResource($deliveryModel) : null;
        } else
            $result['delivery'] = null;

        return $result;
    }
}
