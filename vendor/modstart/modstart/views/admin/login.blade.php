@extends('modstart::admin.frame')

@section('bodyAppend')
    @parent
    {!! \ModStart\Core\Hook\ModStartHook::fireInView('AdminLoginBodyAppend',$this); !!}
@endsection

@section('body')
    <div class="ub-admin-login">
        <div class="head"><i class="iconfont icon-user"></i> {!! L('Admin Login') !!}</div>
        <div class="form">
            <form class="uk-form" method="post" action="?" data-ajax-form>
                <div class="line">
                    {{ L('Username') }}
                    <input type="text" name="username" value="{{\Illuminate\Support\Facades\Input::get('username','')}}" placeholder="{{ L('Please Input') }}"/>
                </div>
                <div class="line">
                    {{ L('Password') }}
                    <input type="password" name="password" value="{{\Illuminate\Support\Facades\Input::get('password','')}}" placeholder="{{ L('Please Input') }}"/>
                </div>
                @if(config('modstart.admin.login.captcha',false))
                    <?php $providerName = modstart_config('AdminManagerEnhance_LoginCaptchaProvider',null); ?>
                    @if($providerName && ($provider = \Module\Vendor\Provider\Captcha\CaptchaProvider::get($providerName)))
                        <?php $provider->setParam('biz','admin'); ?>
                        <div style="padding:0.5rem;">
                            {!! $provider->render() !!}
                        </div>
                    @else
                        <div class="line">
                            {{ L('Captcha') }}
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="captcha" value="" autocomplete="off" placeholder="{{ L('Please Input') }}"/>
                                </div>
                                <div class="col-6">
                                    <img data-captcha style="height:40px;width:100%;border:1px solid #CCC;border-radius:3px;" data-uk-tooltip title="{{ L('Click To Refresh') }}" src="{{action('\ModStart\Admin\Controller\AuthController@loginCaptcha')}}" onclick="this.src='{{action('\ModStart\Admin\Controller\AuthController@loginCaptcha')}}?'+Math.random();" />
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="line">
                    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars(\Illuminate\Support\Facades\Input::get('redirect',config('env.ADMIN_PATH','/admin/'))); ?>">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">{{ L('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
