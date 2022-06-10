@extends($_viewFrame)

@section('pageTitleMain')手机快捷登录@endsection
@section('pageKeywords')手机快捷登录@endsection
@section('pageDescription')手机快捷登录@endsection

@section('headAppend')
    @parent
    {!! \ModStart\Core\Hook\ModStartHook::fireInView('MemberLoginPageHeadAppend'); !!}
@endsection

@section('bodyAppend')
    @parent
    {{\ModStart\ModStart::js('asset/common/commonVerify.js')}}
    <script>
        $(function () {
            new window.api.commonVerify({
                generateServer: '{{$__msRoot}}login/phone_verify',
                selectorTarget: 'input[name=phone]',
                selectorGenerate: '[data-phone-verify-generate]',
                selectorCountdown: '[data-phone-verify-countdown]',
                selectorRegenerate: '[data-phone-verify-regenerate]',
                selectorCaptcha: 'input[name=captcha]',
                selectorCaptchaImg:'img[data-captcha]',
                interval: 60,
            },window.api.dialog);
        });
    </script>
    {!! \ModStart\Core\Hook\ModStartHook::fireInView('MemberLoginPageBodyAppend'); !!}
@endsection


@section('bodyContent')

    <div class="ub-account pb-member-login-account">

        <div class="box" data-member-login-box>
            <div class="nav">
                <a href="javascript:;" class="active">登录</a>
                @if(!modstart_config('registerDisable',false))
                    ·
                    <a href="{{$__msRoot}}register?redirect={{!empty($redirect)?urlencode($redirect):''}}">注册</a>
                @endif
            </div>

            <div class="ub-form flat">
                <form action="?" method="post" data-ajax-form>
                    <div class="line">
                        <div class="field">
                            <input type="text" class="form-lg" name="phone" placeholder="输入手机" />
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <div class="row no-gutters">
                                <div class="col-6">
                                    <input type="text" class="form-lg" name="captcha" autocomplete="off" placeholder="图片验证码" />
                                </div>
                                <div class="col-6">
                                    <img class="captcha captcha-lg" data-captcha title="刷新验证" onclick="this.src='{{$__msRoot}}login/phone_captcha?'+Math.random()" src="{{$__msRoot}}login/phone_captcha?{{time()}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <div class="row no-gutters">
                                <div class="col-6">
                                    <input type="text" class="form-lg" name="verify" placeholder="输入验证码" />
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-lg btn-block" type="button" data-phone-verify-generate>获取验证码</button>
                                    <button class="btn btn-lg btn-block" type="button" data-phone-verify-countdown style="display:none;margin:0;"></button>
                                    <button class="btn btn-lg btn-block" type="button" data-phone-verify-regenerate style="display:none;margin:0;">重新获取</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line">
                        <div class="field">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">登录</button>
                            <input type="hidden" name="redirect" value="{{empty($redirect)?'':$redirect}}">
                        </div>
                    </div>
                </form>
            </div>

            @include('module::Member.View.pc.oauthButtons')

            @if(!modstart_config('retrieveDisable',false))
                <div class="retrieve">
                    忘记密码?
                    <a href="{{$__msRoot}}retrieve?redirect={{urlencode($redirect)}}">找回密码</a>
                </div>
            @endif
        </div>

    </div>

@endsection
