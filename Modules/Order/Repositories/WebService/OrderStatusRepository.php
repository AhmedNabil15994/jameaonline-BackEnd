<?php

namespace Modules\Order\Repositories\WebService;

use Modules\Order\Entities\OrderStatus;
use Hash;
use DB;

class OrderStatusRepository
{
    protected $orderStatus;

    function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    public function getAll($order = 'sort', $sort = 'asc')
    {
        $orderStatuses = $this->orderStatus->orderBy($order, $sort)->get();
        return $orderStatuses;
    }

    public function getAllFinalStatus($order = 'sort', $sort = 'asc')
    {
        $orderStatuses = $this->orderStatus->finalStatus()->orderBy($order, $sort)->get();
        return $orderStatuses;
    }
}
