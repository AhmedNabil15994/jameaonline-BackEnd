<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'vendor_name'   => $this->vendor_name,
            'mobile'        => $this->mobile,
            'section'        => optional($this->section)->title ?? '',
            // 'image'         => $this->image ? url(config('core.config.vendor_requests_img_path') . '/' . $this->image) : null,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
