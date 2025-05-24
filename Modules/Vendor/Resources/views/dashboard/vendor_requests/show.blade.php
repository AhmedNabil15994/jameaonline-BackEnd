@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.vendor_requests.show.title'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.vendor_requests.index')) }}">
                            {{ __('vendor::dashboard.vendor_requests.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('vendor::dashboard.vendor_requests.show.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                Vendor Request Details
            </div>

        </div>
    </div>
@stop
