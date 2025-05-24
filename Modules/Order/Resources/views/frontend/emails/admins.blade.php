@component('mail::message')

  <h2> <center> {{ __('order::frontend.orders.emails.admins.header') }} </center> </h2>

@component('mail::button', ['url' => url(route('dashboard.orders.show', [$order['id'], 'current_orders'])) ])
{{ __('order::frontend.orders.emails.admins.open_order') }}
@endcomponent


@endcomponent
