<?php

namespace Modules\Order\Transformers\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id'                   => $this->id,
            'unread'               => $this->unread,
            'total'                => $this->total,
            'shipping'             => $this->shipping,
            'subtotal'             => $this->subtotal,
            'transaction'          => $this->transactions->method,
            'order_status_id'      => $this->orderStatus->title,
            'deleted_at'           => $this->deleted_at,
            'created_at'           => date('d-m-Y' , strtotime($this->created_at)),
        ];

        if (isset($this->delivery_time['date'])) {
            $result['delivery_time'] = [
                'time' => $this->delivery_time['date'] . ' <br> ' . __('order::dashboard.orders.datatable.delivery.time_from') . ' ' . $this->delivery_time['time_from'] . ' ' . __('order::dashboard.orders.datatable.delivery.time_to') . ' ' . $this->delivery_time['time_to'],
            ];
        } elseif (isset($this->delivery_time['type']) && $this->delivery_time['type'] == 'direct') {
            $result['delivery_time'] = [
                'time' => $this->delivery_time['message'] ?? '',
            ];
        } else {
            $result['delivery_time'] = [
                'time' => '',
            ];
        }

        return $result;
    }
}
