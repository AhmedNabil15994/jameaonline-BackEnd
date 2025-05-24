@component('mail::message')

  <h2> <center> {{ __('order::frontend.orders.emails.vendors.header') }} </center> </h2>

@component('mail::button', ['url' => url(route('vendor.orders.show', [$order['id'], 'current_orders'])) ])
{{ __('order::frontend.orders.emails.vendors.open_order') }}
@endcomponent


@endcomponent
