<?php

namespace Modules\Advertising\Repositories\Dashboard;

use Modules\Advertising\Entities\Advertising;
use DB;

class AdvertisingRepository
{
    protected $advertising;

    function __construct(Advertising $advertising)
    {
        $this->advertising = $advertising;
    }

    public function findById($id)
    {
        $advertising = $this->advertising->withDeleted()->find($id);
        return $advertising;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $data = [
                'ad_group_id' => $request->group_id ?? null,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'image' => path_without_domain($request->image),
                'status' => $request->status ? 1 : 0,
                'sort' => $request->sort ?? 0,
            ];

            if ($request->link_type == 'external')
                $data['link'] = $request->link;
            elseif ($request->link_type == 'product') {
                $data['advertable_id'] = $request->product_id;
                $data['advertable_type'] = 'Modules\Catalog\Entities\Product';
            } elseif ($request->link_type == 'category') {
                $data['advertable_id'] = $request->category_id;
                $data['advertable_type'] = 'Modules\Catalog\Entities\Category';
            }

            $advertising = $this->advertising->create($data);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $advertising = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($advertising) : null;

        try {

            $data = [
                'ad_group_id' => $request->group_id ?? null,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'image' => $request->image ? path_without_domain($request->image) : $advertising->image,
                'status' => $request->status ? 1 : 0,
                'sort' => $request->sort ?? 0,

            ];

            if ($request->link_type == 'external') {
                $data['link'] = $request->link;
                $data['advertable_id'] = null;
                $data['advertable_type'] = null;
            } elseif ($request->link_type == 'product') {
                $data['link'] = null;
                $data['advertable_id'] = $request->product_id;
                $data['advertable_type'] = 'Modules\Catalog\Entities\Product';
            } elseif ($request->link_type == 'category') {
                $data['link'] = null;
                $data['advertable_id'] = $request->category_id;
                $data['advertable_type'] = 'Modules\Catalog\Entities\Category';
            }

            $advertising->update($data);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
                $model->forceDelete();
            else:
                $model->delete();
            endif;

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

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
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
        $query = $this->advertising->where('ad_group_id', $request->advertising_group);
        $query = $this->filterDataTable($query, $request);
        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // SEARCHING INPUT DATATABLE
        if ($request->input('search.value') != null) {

            $query = $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            });

        }

        // FILTER
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) && $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) && $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

}
