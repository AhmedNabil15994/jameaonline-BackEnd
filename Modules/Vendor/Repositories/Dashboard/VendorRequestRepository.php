<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Vendor\Entities\VendorRequest;

class VendorRequestRepository
{
    protected $vendorRequest;

    function __construct(VendorRequest $vendorRequest)
    {
        $this->vendorRequest = $vendorRequest;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->vendorRequest->orderBy($order, $sort)->get();
    }

    public function getVendorRequestsCount()
    {
        return $this->vendorRequest->count();
    }

    public function findById($id)
    {
        return $this->vendorRequest->find($id);
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
        return true;
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $model = $this->findById($id);
            if ($model) {
                if ($model->trashed()) :
                    $model->forceDelete();
                else :
                    $model->delete();
                endif;
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();
        try {
            if (!empty($request['ids'])) {
                foreach ($request['ids'] as $id) {
                    $model = $this->delete($id);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->vendorRequest->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orwhere(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search.value') . '%');
                $query->orwhere('vendor_name', 'like', '%' . $request->input('search.value') . '%');
                $query->orwhere('mobile', 'like', '%' . $request->input('search.value') . '%');
            });
            $query->orWhereHas('section', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        $query = $this->filterDataTable($query, $request);
        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Pages by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        return $query;
    }
}
