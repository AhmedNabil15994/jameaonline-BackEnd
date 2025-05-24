@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.categories.routes.create'))
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
                        <a href="{{ url(route('dashboard.vendor_categories.index')) }}">
                            {{__('vendor::dashboard.categories.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('vendor::dashboard.categories.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.vendor_categories.store')}}">
                    @csrf
                    <div class="col-md-12">

                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                    </div>
                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('vendor::dashboard.categories.form.tabs.general') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#category_level" data-toggle="tab">
                                                        {{ __('vendor::dashboard.categories.form.tabs.category_level') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="tab-content">
                                <div class="tab-pane active fade in" id="global_setting">
                                    {{--                                    <h3 class="page-title">{{__('vendor::dashboard.categories.form.tabs.general')}}</h3>--}}
                                    <div class="col-md-10">


                                        {{--  tab for lang --}}
                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if($loop->first) active @endif">
                                                    <a data-toggle="tab"
                                                       href="#first_{{$code}}">{{__('vendor::dashboard.categories.form.tabs.input_lang',["lang"=>$code])}}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{--  tab for content --}}
                                        <div class="tab-content">

                                            @foreach (config('translatable.locales') as $code)
                                                <div id="first_{{$code}}"
                                                     class="tab-pane fade @if($loop->first) in active @endif">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('vendor::dashboard.categories.form.title')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]"
                                                                   class="form-control"
                                                                   data-name="title.{{$code}}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>


                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('vendor::dashboard.categories.form.image')}}
                                            </label>
                                            <div class="col-md-9">
                                                @include('core::dashboard.shared.file_upload', ['image' => null])
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('vendor::dashboard.categories.form.cover')}}
                                            </label>
                                            <div class="col-md-9">
                                                @include('core::dashboard.shared.file_upload', ['image' => null, 'name' => 'cover', 'imgUploadPreviewID' => 'coverImgUploadPreview'])
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('vendor::dashboard.categories.form.color')}}
                                            </label>
                                            <div class="col-md-3">
                                                <input type="color" name="color" class="form-control" data-name="color">
                                                {{--<code>{{__('vendor::dashboard.categories.form.color_hint')}}</code>--}}
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('vendor::dashboard.categories.form.sort')}}
                                            </label>
                                            <div class="col-md-3">
                                                <input type="number" name="sort" class="form-control" data-name="sort"
                                                       value="0">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('vendor::dashboard.categories.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="status" data-size="small"
                                                       name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('vendor::dashboard.categories.form.show_in_home')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="show_in_home"
                                                       data-size="small"
                                                       name="show_in_home">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="vendor_category_id" id="root_category" value="">
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="category_level">
                                    {{--                                    <h3 class="page-title">{{ __('vendor::dashboard.categories.form.tabs.category_level') }}</h3>--}}
                                    <div id="jstree">
                                        {{--<ul>
                                                <li id="null">{{ __('vendor::dashboard.categories.form.main_category') }}</li>
                                            </ul>--}}

                                        @include('vendor::dashboard.tree.categories.view',['mainVendorCategories' =>
                                        $mainVendorCategories])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{__('apps::dashboard.general.add_btn')}}
                                    </button>
                                    <a href="{{url(route('dashboard.vendor_categories.index')) }}"
                                       class="btn btn-lg red">
                                        {{__('apps::dashboard.general.back_btn')}}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('scripts')

    <script type="text/javascript">
        $(function () {

            $('#jstree').jstree({
                core: {
                    multiple: false
                }
            });

            $('#jstree').on("changed.jstree", function (e, data) {
                $('#root_category').val(data.selected);
            });

        });
    </script>

@endsection
