<?php

namespace Modules\Vendor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Vendor\Transformers\Dashboard\VendorRequestResource;
use Modules\Vendor\Repositories\Dashboard\VendorRequestRepository as VendorRequestRepo;
use OrderStatusSeeder;

class VendorRequestController extends Controller
{
    protected $vendorRequest;

    function __construct(VendorRequestRepo $vendorRequest)
    {
        $this->vendorRequest = $vendorRequest;
    }

    public function index()
    {
        return view('vendor::dashboard.vendor_requests.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->vendorRequest->QueryTable($request));
        $datatable['data'] = VendorRequestResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function show($id)
    {
        abort(404);

        $vendorRequest = $this->vendorRequest->findById($id);
        if (!$vendorRequest)
            abort(404);

        return view('vendor::dashboard.vendor_requests.show', compact('vendorRequest'));
    }

    public function destroy($id)
    {
        try {
            $delete = $this->vendorRequest->delete($id);
            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->vendorRequest->deleteSelected($request);
            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
