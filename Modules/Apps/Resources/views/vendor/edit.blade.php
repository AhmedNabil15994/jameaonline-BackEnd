@extends('apps::vendor.layouts.app')
@section('title', __('vendor::dashboard.vendors.update.title'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('vendor.home')) }}">{{ __('apps::vendor.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('vendor::dashboard.vendors.update.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('vendor.update.info', $vendor->id) }}">
                    @csrf
                    @method('POST')

                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-md-2">
                                {{ __('vendor::dashboard.vendors.create.form.busy') }}
                            </label>
                            <div class="col-md-4">


                                <input type="checkbox" class="make-switch" id="busy" data-size="small"
                                    name="vendor_status_id" {{ $vendor->vendor_status_id == 4 ? ' checked="" ' : '' }}>
                                <div class="help-block"></div>


                                {{-- <select name="vendor_status_id" id="single"
                                        class="form-control select2-allow-clear">
                                    <option value=""></option>
                                    @foreach ($vendorStatuses as $vendorStatus)
                                        <option value="{{ $vendorStatus['id'] }}"
                                                @if ($vendor->vendor_status_id == $vendorStatus['id'])
                                                selected
                                            @endif>
                                            {{ $vendorStatus->title }}
                                        </option>
                                    @endforeach
                                </select> --}}

                            </div>
                        </div>

                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg green">
                                    {{ __('apps::dashboard.general.edit_btn') }}
                                </button>
                                <a href="{{ url(route('vendor.home')) }}" class="btn btn-lg red">
                                    {{ __('apps::dashboard.general.back_btn') }}
                                </a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop
