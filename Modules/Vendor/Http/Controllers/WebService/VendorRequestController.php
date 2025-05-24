<?php

namespace Modules\Vendor\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Vendor\Http\Requests\WebService\VendorReqRequest;
use Modules\Vendor\Repositories\WebService\VendorRequestRepository as VendorRequestRepo;
use Modules\Vendor\Traits\UploaderTrait;

class VendorRequestController extends WebServiceController
{
    use UploaderTrait;

    protected $vendorRequest;

    function __construct(VendorRequestRepo $vendorRequest)
    {
        $this->vendorRequest = $vendorRequest;
    }

    public function createVendorRequest(VendorReqRequest $request)
    {
        $vendorRequest = $this->vendorRequest->create($request);
        if ($vendorRequest)
            return $this->response(null, __('vendor::frontend.vendor_requests.alerts.created_successfully'));
        else
            return $this->error(__('vendor::frontend.vendor_requests.alerts.error_occured'));
    }
}
