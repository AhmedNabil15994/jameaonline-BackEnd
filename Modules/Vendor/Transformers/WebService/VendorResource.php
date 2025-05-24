<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\WebService\PaginatedResource;
use Modules\Catalog\Transformers\WebService\ProductResource;
use Modules\Vendor\Traits\VendorTrait;

class VendorResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => !is_null($this->image) ? url($this->image) : null,
            'logo' => !is_null($this->logo) ? url($this->logo) : null,
            'title' => $this->title,
            'description' => $this->description,
            // 'opening_status' => new OpeningStatusResource($this->openingStatus),
            'rate' => $this->getVendorRate($this->id),
            'vendor_categories' => VendorCategoryResource::collection($this->categories),
            'section' => new SectionResource($this->section),
            'payment_methods' => $this->payment_methods ?? [],
            'working_hours' => $this->working_hours ?? null,
            'offer_text' => $this->offer_text ?? null,

            'address' => $this->address ?? null,
            'mobile' => !is_null($this->mobile) ? /*$this->calling_code .*/ $this->mobile : null,
            'whatsapp' => $this->whatsapp ?? null,

            /*'payments' => PaymenteResource::collection($this->payments),
            'fixed_delivery' => $this->fixed_delivery,
            'order_limit' => $this->order_limit,
            'rate' => $this->getVendorTotalRate($this->rates),*/
        ];

        $result['opening_status'] = $this->checkVendorBusyStatus($this->id);

        if (!is_null($request->state_id)) {
            $deliveryModel = $this->getVendorDeliveryByState($this->id, $request->state_id);
            $result['delivery'] = $deliveryModel ? new DeliveryChargeResource($deliveryModel) : null;
        } else {
            $result['delivery'] = null;
        }

        if (request()->get('with_products') == 'yes') {
            $productsCount = request()->get('with_products_count') ?? 10;
            $result['products'] = ProductResource::collection($this->products->take($productsCount));
        }

        /* if (request()->route()->getName() == 'api.get_one_vendor') {
            $products = $request->products;
            $request->request->remove('products');
            $result['products'] = PaginatedResource::make($products)->mapInto(ProductResource::class);
        } */

        return $result;
    }
}
