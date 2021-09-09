layui.define("jquery",function(e){"use strict";function k(e){var i={h:0,s:0,b:0},o=Math.min(e.r,e.g,e.b),r=Math.max(e.r,e.g,e.b),t=r-o;return i.b=r,i.s=0!=r?255*t/r:0,0!=i.s?e.r==r?i.h=(e.g-e.b)/t:e.g==r?i.h=2+(e.b-e.r)/t:i.h=4+(e.r-e.g)/t:i.h=-1,r==o&&(i.h=0),i.h*=60,i.h<0&&(i.h+=360),i.s*=100/255,i.b*=100/255,i}function y(e){var i={},o=e.h,r=255*e.s/100,t=255*e.b/100;return 0==r?i.r=i.g=i.b=t:(t=o%60*((e=t)-(r=(255-r)*t/255))/60,(o=360==o?0:o)<60?(i.r=e,i.b=r,i.g=r+t):o<120?(i.g=e,i.b=r,i.r=e-t):o<180?(i.g=e,i.r=r,i.b=r+t):o<240?(i.b=e,i.r=r,i.g=e-t):o<300?(i.b=e,i.g=r,i.r=r+t):o<360?(i.r=e,i.g=r,i.b=e-t):(i.r=0,i.g=0,i.b=0)),{r:Math.round(i.r),g:Math.round(i.g),b:Math.round(i.b)}}function f(e){var o=[(e=y(e)).r.toString(16),e.g.toString(16),e.b.toString(16)];return C.each(o,function(e,i){1==i.length&&(o[e]="0"+i)}),o.join("")}function x(e){return{r:(e=e.match(/[0-9]{1,3}/g)||[])[0],g:e[1],b:e[2]}}function t(e){this.index=++i.index,this.config=C.extend({},this.config,i.config,e),this.render()}var C=layui.jquery,i={config:{},index:layui.colorpicker?layui.colorpicker.index+1e4:0,set:function(e){var i=this;return i.config=C.extend({},i.config,e),i},on:function(e,i){return layui.onevent.call(this,"colorpicker",e,i)}},r="layui-colorpicker",n=".layui-colorpicker-main",P="layui-icon-down",B="layui-icon-close",w="layui-colorpicker-trigger-span",D="layui-colorpicker-trigger-i",E="layui-colorpicker-side-slider",H="layui-colorpicker-basis",W="layui-colorpicker-alpha-bgcolor",j="layui-colorpicker-alpha-slider",F="layui-colorpicker-basis-cursor",L="layui-colorpicker-main-input",M=C(window),l=C(document);t.prototype.config={color:"",size:null,alpha:!1,format:"hex",predefine:!1,colors:["#009688","#5FB878","#1E9FFF","#FF5722","#FFB800","#01AAED","#999","#c00","#ff8c00","#ffd700","#90ee90","#00ced1","#1e90ff","#c71585","rgb(0, 186, 189)","rgb(255, 120, 0)","rgb(250, 212, 0)","#393D49","rgba(0,0,0,.5)","rgba(255, 69, 0, 0.68)","rgba(144, 240, 144, 0.5)","rgba(31, 147, 255, 0.73)"]},t.prototype.render=function(){var e,i=this,o=i.config,r=C(['<div class="layui-unselect layui-colorpicker">',"<span "+("rgb"==o.format&&o.alpha?'class="layui-colorpicker-trigger-bgcolor"':"")+">",'<span class="layui-colorpicker-trigger-span" ','lay-type="'+("rgb"==o.format?o.alpha?"rgba":"torgb":"")+'" ','style="'+(e="",o.color?(e=o.color,3<(o.color.match(/[0-9]{1,3}/g)||[]).length&&(o.alpha&&"rgb"==o.format||(e="#"+f(k(x(o.color))))),"background: "+e):e)+'">','<i class="layui-icon layui-colorpicker-trigger-i '+(o.color?P:B)+'"></i>',"</span>","</span>","</div>"].join("")),e=C(o.elem);o.size&&r.addClass("layui-colorpicker-"+o.size),e.addClass("layui-inline").html(i.elemColorBox=r),i.color=i.elemColorBox.find("."+w)[0].style.background,i.events()},t.prototype.renderPicker=function(){var e=this,i=e.config,o=e.elemColorBox[0],r=e.elemPicker=C(['<div id="layui-colorpicker'+e.index+'" data-index="'+e.index+'" class="layui-anim layui-anim-upbit layui-colorpicker-main">','<div class="layui-colorpicker-main-wrapper">','<div class="layui-colorpicker-basis">','<div class="layui-colorpicker-basis-white"></div>','<div class="layui-colorpicker-basis-black"></div>','<div class="layui-colorpicker-basis-cursor"></div>',"</div>",'<div class="layui-colorpicker-side">','<div class="layui-colorpicker-side-slider"></div>',"</div>","</div>",'<div class="layui-colorpicker-main-alpha '+(i.alpha?"layui-show":"")+'">','<div class="layui-colorpicker-alpha-bgcolor">','<div class="layui-colorpicker-alpha-slider"></div>',"</div>","</div>",function(){if(i.predefine){var o=['<div class="layui-colorpicker-main-pre">'];return layui.each(i.colors,function(e,i){o.push(['<div class="layui-colorpicker-pre'+(3<(i.match(/[0-9]{1,3}/g)||[]).length?" layui-colorpicker-pre-isalpha":"")+'">','<div style="background:'+i+'"></div>',"</div>"].join(""))}),o.push("</div>"),o.join("")}return""}(),'<div class="layui-colorpicker-main-input">','<div class="layui-inline">','<input type="text" class="layui-input">',"</div>",'<div class="layui-btn-container">','<button class="layui-btn layui-btn-primary layui-btn-sm" colorpicker-events="clear">清空</button>','<button class="layui-btn layui-btn-sm" colorpicker-events="confirm">确定</button>',"</div","</div>","</div>"].join(""));e.elemColorBox.find("."+w)[0],C(n)[0]&&C(n).data("index")==e.index?e.removePicker(t.thisElemInd):(e.removePicker(t.thisElemInd),C("body").append(r)),t.thisElemInd=e.index,t.thisColor=o.style.background,e.position(),e.pickerEvents()},t.prototype.removePicker=function(e){return this.config,C("#layui-colorpicker"+(e||this.index)).remove(),this},t.prototype.position=function(){function e(e){return e=e?"scrollLeft":"scrollTop",document.body[e]|document.documentElement[e]}function i(e){return document.documentElement[e?"clientWidth":"clientHeight"]}var o=this.config,r=this.bindElem||this.elemColorBox[0],t=this.elemPicker[0],n=r.getBoundingClientRect(),l=t.offsetWidth,c=t.offsetHeight,a=n.left,s=n.bottom;s+=5,(a-=(l-r.offsetWidth)/2)+l+5>i("width")?a=i("width")-l-5:a<5&&(a=5),s+c+5>i()&&(s=n.top>c?n.top-c:i()-c,s-=10),o.position&&(t.style.position=o.position),t.style.left=a+("fixed"===o.position?0:e(1))+"px",t.style.top=s+("fixed"===o.position?0:e())+"px"},t.prototype.val=function(){var e,i=this,o=(i.config,i.elemColorBox.find("."+w)),r=i.elemPicker.find("."+L),t=o[0].style.backgroundColor;t?(e=k(x(t)),o=o.attr("lay-type"),i.select(e.h,e.s,e.b),"torgb"===o&&r.find("input").val(t),"rgba"===o&&(o=x(t),3==(t.match(/[0-9]{1,3}/g)||[]).length?(r.find("input").val("rgba("+o.r+", "+o.g+", "+o.b+", 1)"),i.elemPicker.find("."+j).css("left",280)):(r.find("input").val(t),t=280*t.slice(t.lastIndexOf(",")+1,t.length-1),i.elemPicker.find("."+j).css("left",t)),i.elemPicker.find("."+W)[0].style.background="linear-gradient(to right, rgba("+o.r+", "+o.g+", "+o.b+", 0), rgb("+o.r+", "+o.g+", "+o.b+"))")):(i.select(0,100,100),r.find("input").val(""),i.elemPicker.find("."+W)[0].style.background="",i.elemPicker.find("."+j).css("left",280))},t.prototype.side=function(){function s(e,i,o,r){t.select(e,i,o),o=y({h:e,s:i,b:o}),m.addClass(P).removeClass(B),l[0].style.background="rgb("+o.r+", "+o.g+", "+o.b+")","torgb"===c&&t.elemPicker.find("."+L).find("input").val("rgb("+o.r+", "+o.g+", "+o.b+")"),"rgba"===c&&(u.css("left",280*r),t.elemPicker.find("."+L).find("input").val("rgba("+o.r+", "+o.g+", "+o.b+", "+r+")"),l[0].style.background="rgba("+o.r+", "+o.g+", "+o.b+", "+r+")",f[0].style.background="linear-gradient(to right, rgba("+o.r+", "+o.g+", "+o.b+", 0), rgb("+o.r+", "+o.g+", "+o.b+"))"),n.change&&n.change(t.elemPicker.find("."+L).find("input").val())}function i(e){C("#LAY-colorpicker-moving")[0]||C("body").append(b),b.on("mousemove",e),b.on("mouseup",function(){b.remove()}).on("mouseleave",function(){b.remove()})}var t=this,n=t.config,l=t.elemColorBox.find("."+w),c=l.attr("lay-type"),a=t.elemPicker.find(".layui-colorpicker-side"),e=t.elemPicker.find("."+E),d=t.elemPicker.find("."+H),r=t.elemPicker.find("."+F),f=t.elemPicker.find("."+W),u=t.elemPicker.find("."+j),p=e[0].offsetTop/180*360,g=100-(r[0].offsetTop+3)/180*100,h=(r[0].offsetLeft+3)/260*100,v=Math.round(u[0].offsetLeft/280*100)/100,m=t.elemColorBox.find("."+D),o=t.elemPicker.find(".layui-colorpicker-pre").children("div"),b=C(['<div class="layui-auxiliar-moving" id="LAY-colorpicker-moving"></div'].join(""));e.on("mousedown",function(e){var r=this.offsetTop,t=e.clientY;i(function(e){var i=r+(e.clientY-t),o=a[0].offsetHeight,i=(i=o<(i=i<0?0:i)?o:i)/180*360;s(p=i,h,g,v),e.preventDefault()}),e.preventDefault()}),a.on("click",function(e){var i=e.clientY-C(this).offset().top,i=(i=(i=i<0?0:i)>this.offsetHeight?this.offsetHeight:i)/180*360;s(p=i,h,g,v),e.preventDefault()}),r.on("mousedown",function(e){var n=this.offsetTop,l=this.offsetLeft,c=e.clientY,a=e.clientX;layui.stope(e),i(function(e){var i=n+(e.clientY-c),o=l+(e.clientX-a),r=d[0].offsetHeight-3,t=d[0].offsetWidth-3,o=((o=t<(o=o<-3?-3:o)?t:o)+3)/260*100,i=100-((i=r<(i=i<-3?-3:i)?r:i)+3)/180*100;s(p,h=o,g=i,v),e.preventDefault()}),e.preventDefault()}),d.on("mousedown",function(e){var i=e.clientY-C(this).offset().top-3+M.scrollTop(),o=e.clientX-C(this).offset().left-3+M.scrollLeft();(i=i<-3?-3:i)>this.offsetHeight-3&&(i=this.offsetHeight-3);o=((o=(o=o<-3?-3:o)>this.offsetWidth-3?this.offsetWidth-3:o)+3)/260*100,i=100-(i+3)/180*100;s(p,h=o,g=i,v),e.preventDefault(),r.trigger(e,"mousedown")}),u.on("mousedown",function(e){var r=this.offsetLeft,t=e.clientX;i(function(e){var i=r+(e.clientX-t),o=f[0].offsetWidth;o<(i=i<0?0:i)&&(i=o);i=Math.round(i/280*100)/100;s(p,h,g,v=i),e.preventDefault()}),e.preventDefault()}),f.on("click",function(e){var i=e.clientX-C(this).offset().left;(i=i<0?0:i)>this.offsetWidth&&(i=this.offsetWidth);i=Math.round(i/280*100)/100;s(p,h,g,v=i),e.preventDefault()}),o.each(function(){C(this).on("click",function(){C(this).parent(".layui-colorpicker-pre").addClass("selected").siblings().removeClass("selected");var e=this.style.backgroundColor,i=k(x(e)),o=e.slice(e.lastIndexOf(",")+1,e.length-1);p=i.h,h=i.s,g=i.b,3==(e.match(/[0-9]{1,3}/g)||[]).length&&(o=1),v=o,s(i.h,i.s,i.b,o)})})},t.prototype.select=function(e,i,o,r){var t=this,n=(t.config,f({h:e,s:100,b:100})),l=f({h:e,s:i,b:o}),e=e/360*180,o=180-o/100*180-3,i=i/100*260-3;t.elemPicker.find("."+E).css("top",e),t.elemPicker.find("."+H)[0].style.background="#"+n,t.elemPicker.find("."+F).css({top:o,left:i}),"change"!==r&&t.elemPicker.find("."+L).find("input").val("#"+l)},t.prototype.pickerEvents=function(){var c=this,a=c.config,s=c.elemColorBox.find("."+w),d=c.elemPicker.find("."+L+" input"),o={clear:function(e){s[0].style.background="",c.elemColorBox.find("."+D).removeClass(P).addClass(B),c.color="",a.done&&a.done(""),c.removePicker()},confirm:function(e,i){var o,r,t=d.val(),n=t,l={};return-1<t.indexOf(",")?(l=k(x(t)),c.select(l.h,l.s,l.b),s[0].style.background=n="#"+f(l),3<(t.match(/[0-9]{1,3}/g)||[]).length&&"rgba"===s.attr("lay-type")&&(r=280*t.slice(t.lastIndexOf(",")+1,t.length-1),c.elemPicker.find("."+j).css("left",r),n=s[0].style.background=t)):(3==(o=-1<(o=t).indexOf("#")?o.substring(1):o).length&&(o=(r=o.split(""))[0]+r[0]+r[1]+r[1]+r[2]+r[2]),o=parseInt(o,16),l=k({r:o>>16,g:(65280&o)>>8,b:255&o}),s[0].style.background=n="#"+f(l),c.elemColorBox.find("."+D).removeClass(B).addClass(P)),"change"===i?(c.select(l.h,l.s,l.b,i),void(a.change&&a.change(n))):(c.color=t,a.done&&a.done(t),void c.removePicker())}};c.elemPicker.on("click","*[colorpicker-events]",function(){var e=C(this),i=e.attr("colorpicker-events");o[i]&&o[i].call(this,e)}),d.on("keyup",function(e){var i=C(this);o.confirm.call(this,i,13===e.keyCode?null:"change")})},t.prototype.events=function(){var i=this,e=i.config,o=i.elemColorBox.find("."+w);i.elemColorBox.on("click",function(){i.renderPicker(),C(n)[0]&&(i.val(),i.side())}),e.elem[0]&&!i.elemColorBox[0].eventHandler&&(l.on("click",function(e){C(e.target).hasClass(r)||C(e.target).parents("."+r)[0]||C(e.target).hasClass(n.replace(/\./g,""))||C(e.target).parents(n)[0]||!i.elemPicker||(i.color?(e=k(x(i.color)),i.select(e.h,e.s,e.b)):i.elemColorBox.find("."+D).removeClass(P).addClass(B),o[0].style.background=i.color||"",i.removePicker())}),M.on("resize",function(){return!(!i.elemPicker||!C(n)[0])&&void i.position()}),i.elemColorBox[0].eventHandler=!0)},i.render=function(e){e=new t(e);return function(){return{config:this.config}}.call(e)},e("colorpicker",i)});