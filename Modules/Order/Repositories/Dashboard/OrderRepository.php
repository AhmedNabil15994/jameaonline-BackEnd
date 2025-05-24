<?php

namespace Modules\Order\Repositories\Dashboard;

use Modules\Order\Traits\OrderCalculationTrait;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{
    use OrderCalculationTrait, ShoppingCartTrait;

    protected $order;

    function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"))
            ->pluck('date');

        $ordersIncome = $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->select(DB::raw("sum(total) as profit"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $data["profits"] = json_encode(array_column($ordersIncome->toArray(), 'profit'));

        return $data;
    }

    public function ordersType()
    {
        $orders = $this->order
            ->with('orderStatus')
            ->select("order_status_id", DB::raw("count(id) as count"))
            ->groupBy('order_status_id')
            ->get();


        foreach ($orders as $order) {

            $status = $order->orderStatus->title;
            $order->type = $status;
        }

        $data["ordersCount"] = json_encode(array_column($orders->toArray(), 'count'));
        $data["ordersType"] = json_encode(array_column($orders->toArray(), 'type'));

        return $data;
    }

    public function totalTodayProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->whereDate("created_at", DB::raw('CURDATE()'))
            ->sum('total');
    }

    public function totalMonthProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->whereMonth("created_at", date("m"))
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function totalYearProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function completeOrders()
    {
        $orders = $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })->count();

        return $orders;
    }

    public function totalProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successOrderStatus();
        })->sum('total');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->orderBy($order, $sort)->get();
        return $orders;
    }

    public function getOrdersCountByFlag($flag = 'all_orders')
    {
        $query = $this->order->whereNull('deleted_at');
        if ($flag == 'current_orders') {
            $query = $this->orderStatusRelationByFlag($query, ['new_order', 'received', 'processing', 'is_ready']);
        } elseif ($flag == 'completed_orders') {
            $query = $this->orderStatusRelationByFlag($query, ['on_the_way', 'delivered']);
        } elseif ($flag == 'not_completed_orders') {
            $query = $this->orderStatusRelationByFlag($query, ['failed']);
        } elseif ($flag == 'refunded_orders') {
            $query = $this->orderStatusRelationByFlag($query, ['refund']);
        }
        return $query->count();
    }

    private function orderStatusRelationByFlag($query, $flag = [])
    {
        return $query->whereHas('orderStatus', function ($query) use ($flag) {
            $query->whereIn('flag', $flag);
        });
    }

    public function findById($id)
    {
        $order = $this->order
            ->with([
                'orderProducts.product',
                'orderVariations.variant.product',
            ])->withDeleted()->find($id);

        return $order;
    }

    public function updateUnread($id)
    {
        $order = $this->findById($id);
        if (!$order)
            abort(404);

        $order->update([
            'unread' => true,
        ]);
    }

    public function updateOrderStatusAndDriver($request, $id)
    {
        DB::beginTransaction();
        try {
            $order = $this->findById($id);
            if (!$order)
                abort(404);

            $orderData = ['order_status_id' => $request['order_status']];
            if (isset($request['order_notes']) && !empty($request['order_notes']))
                $orderData['order_notes'] = $request['order_notes'];

            $order->update($orderData);
            $order->orderStatusesHistory()->attach([$request['order_status'] => ['user_id' => auth()->id()]]);

            if ($request['user_id']) {
                $order->driver()->delete();
                $order->driver()->updateOrCreate([
                    'user_id' => $request['user_id'],
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
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
            } else {
                return false;
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
            } else {
                return false;
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getSelectedOrdersById($ids)
    {
        // $newIds = [];
        // foreach ($ids as $id) {
        //     $newIds[] = substr($id, 0, strrpos($id, ' ')); // remove everything after space. ex: "9 class="
        // }

        $orders = $this->order
            ->with([
                'orderProducts',
                'orderVariations',
                'user',
                'orderAddress',
                'unknownOrderAddress',
                'driver',
                'vendors',
                'companies',
                'transactions',
            ]);

        $orders = $orders->whereIn('id', $ids)->get();
        return $orders;
    }

    public function customQueryTable($request, $flags = [])
    {
        $query = $this->order->with('orderAddress.state');

        if (!empty($flags)) {
            $query = $query->whereHas('orderStatus', function ($query) use ($flags) {
                $query->whereIn('flag', $flags);
            });
        }

        $query = $query->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('orderAddress', function ($query) use ($request) {
                    $query->where('username', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhereHas('state', function ($query) use ($request) {
                        $query->where('title', '%' . $request->input('search.value') . '%');
                    });
                });
            });
        });
        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
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

        if (isset($request['req']['vendor']) && !empty($request['req']['vendor'])) {
            $query->whereHas('vendors', function ($q) use ($request) {
                $q->where('order_vendors.vendor_id', $request['req']['vendor']);
            });
        }

        if (isset($request['req']['order_status']) && !empty($request['req']['order_status'])) {
            $query->whereHas('orderStatus', function ($q) use ($request) {
                $q->where('id', $request['req']['order_status']);
            });
        }

        return $query;
    }

    public function getOnlinePendingOrders()
    {
        $currentDate = new \DateTime;
        $currentDate->modify('-15 minutes');
        $formattedDate = $currentDate->format('Y-m-d H:i:s');

        $orders = $this->order
            ->with([
                'orderProducts' => function ($query) {
                    $query->with('product');
                },
                'orderVariations' => function ($query) {
                    $query->with('variant');
                },
            ]);

        // pending orders
        $orders = $orders->where('payment_status_id', 1)
            ->where('order_status_id', 1);

        // get order after 15 minutes
        $orders = $orders->where('created_at', '<=', $formattedDate);

        return $orders->get();
    }
}
