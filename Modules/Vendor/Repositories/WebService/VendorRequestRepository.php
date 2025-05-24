<?php

namespace Modules\Vendor\Repositories\WebService;

use Modules\Vendor\Entities\VendorRequest;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\CoreTrait;

class VendorRequestRepository
{
    use CoreTrait;

    protected $vendorRequest;

    function __construct(VendorRequest $vendorRequest)
    {
        $this->vendorRequest = $vendorRequest;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'name' => $request->name,
                'vendor_name' => $request->vendor_name,
                // 'vendor_email' => $request->vendor_email ?? null,
                'calling_code' => $request->calling_code ?? '965',
                'mobile' => $request->mobile,
                'section_id' => $request->section_id,
                'instagram_link' => $request->instagram_link,
                // 'vendor_short_decription' => $request->vendor_short_decription,
            ];

            /* if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.vendor_requests_img_path')), $request->image);
                $data['image'] = $imgName;
            } else {
                $data['image'] = url(config('setting.logo'));
            } */

            $vendorRequest = $this->vendorRequest->create($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
