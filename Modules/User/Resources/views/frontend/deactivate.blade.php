<html dir="{{locale() == 'ar' ? 'rtl' : 'ltr'}}">
    @section('title',__('authentication::dashboard.login.routes.deactivate'))
    <link rel="stylesheet" href="{{ url('admin/assets/pages/css/login.min.css') }}">
    @if(locale() == 'ar')
        @include('apps::dashboard.layouts._head_rtl')
    @else
        @include('apps::dashboard.layouts._head_ltr')
    @endif
    @if(session('msg'))
        @include('apps::dashboard.layouts._msg')
    @endif
    <body class="login">
        <div class="content">
            <form class="login-form" action="{{ route('frontend.users.deactivate') }}" method="POST">
                {{ csrf_field() }}
                <h3 class="form-title font-green">{{ __('authentication::dashboard.login.routes.deactivate') }}</h3>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label">
                      {{ __('authentication::dashboard.login.form.email') }}
                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" value="{{ old('email') }}" name="email"/>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                    <label class="control-label">
                      {{ __('authentication::dashboard.login.form.password') }}
                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" name="password"/>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">
                      {{ __('authentication::dashboard.login.form.btn.deactivate') }}
                    </button>
                </div>
            </form>
        </div>
        @include('apps::dashboard.layouts._footer')
        @include('apps::dashboard.layouts._jquery')
    </body>
</html>
