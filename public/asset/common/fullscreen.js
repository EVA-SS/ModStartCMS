!function(t){var u={};function l(e){if(u[e])return u[e].exports;var n=u[e]={i:e,l:!1,exports:{}};return t[e].call(n.exports,n,n.exports,l),n.l=!0,n.exports}l.m=t,l.c=u,l.d=function(e,n,t){l.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:t})},l.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},l.t=function(n,e){if(1&e&&(n=l(n)),8&e)return n;if(4&e&&"object"==typeof n&&n&&n.__esModule)return n;var t=Object.create(null);if(l.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:n}),2&e&&"string"!=typeof n)for(var u in n)l.d(t,u,function(e){return n[e]}.bind(null,u));return t},l.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return l.d(n,"a",n),n},l.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},l.p="/asset/",l(l.s=301)}({301:function(e,n){var t={enter:function(e){var n=document.documentElement;n.requestFullscreen?(n.requestFullscreen(),setTimeout(function(){e&&e()},1e3)):n.mozRequestFullScreen?(n.mozRequestFullScreen(),setTimeout(function(){e&&e()},1e3)):n.webkitRequestFullScreen?(n.webkitRequestFullScreen(),setTimeout(function(){e&&e()},1e3)):elem.msRequestFullscreen&&(elem.msRequestFullscreen(),setTimeout(function(){e&&e()},1e3))},exit:function(e){document.exitFullscreen?(document.exitFullscreen(),setTimeout(function(){e&&e()},1e3)):document.mozCancelFullScreen?(document.mozCancelFullScreen(),setTimeout(function(){e&&e()},1e3)):document.webkitCancelFullScreen?(document.webkitCancelFullScreen(),setTimeout(function(){e&&e()},1e3)):document.msExitFullscreen&&(document.msExitFullscreen(),setTimeout(function(){e&&e()},1e3))},isFullScreen:function(){return document.exitFullscreen?document.fullscreen:document.mozCancelFullScreen?document.mozFullScreen:document.webkitCancelFullScreen?document.webkitIsFullScreen:!!document.msExitFullscreen&&document.msFullscreenElement},trigger:function(e){t.isFullScreen()?t.exit(function(){e("exit")}):t.enter(function(){e("enter")})}};window.api.fullscreen=t}});