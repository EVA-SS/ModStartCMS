!function(r){var n={};function o(e){if(n[e])return n[e].exports;var t=n[e]={i:e,l:!1,exports:{}};return r[e].call(t.exports,t,t.exports,o),t.l=!0,t.exports}o.m=r,o.c=n,o.d=function(e,t,r){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(t,e){if(1&e&&(t=o(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(o.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)o.d(r,n,function(e){return t[e]}.bind(null,n));return r},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="/asset/",o(o.s=294)}({294:function(e,t,r){var i=r(6);window.api.commonVerify=function(e){var r=i.extend({generateServer:"",selectorTarget:"",selectorGenerate:"",selectorCountdown:"",selectorRegenerate:"",selectorCaptcha:"",selectorCaptchaImg:"",interval:60,tipError:function(e){window.api.dialog.tipError(e)},sendError:function(e){window.api.dialog.tipError(e)}},e),n=0,o=function(){var e=i(r.selectorCountdown);e.is("input")?e.val(n+" s"):e.html(n+" s"),0<n?(n--,setTimeout(o,1e3),i(r.selectorCountdown).show(),i(r.selectorRegenerate).hide()):(e.hide(),i(r.selectorCountdown).hide(),i(r.selectorRegenerate).show())},a=!1,e=function(){var e=i(r.selectorTarget).val(),t=null;return r.selectorCaptcha&&!(t=i(r.selectorCaptcha).val())?r.tipError("图片验证码为空"):a||(a=!0,window.api.dialog.loadingOn(),window.api.base.post(r.generateServer,{target:e,captcha:t},function(e){window.api.dialog.loadingOff(),a=!1,window.api.base.defaultFormCallback(e,{success:function(e){e.data&&alert(e.data),i(r.selectorGenerate).hide(),n=r.interval,o(n)},error:function(e){i(r.selectorCaptchaImg).click(),e.data&&alert(e.data),r.sendError(e.msg)}})})),!1};i(r.selectorGenerate).on("click",e),i(r.selectorRegenerate).on("click",e)}},6:function(e,t){e.exports=window.$}});