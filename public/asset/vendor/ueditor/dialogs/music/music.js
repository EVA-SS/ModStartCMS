function Music(){this.init()}!function(){var o=[],p=[],t=null;Music.prototype={total:70,pageSize:10,dataUrl:"http://tingapi.ting.baidu.com/v1/restserver/ting?method=baidu.ting.search.common",playerUrl:"http://box.baidu.com/widget/flash/bdspacesong.swf",init:function(){var s=this;domUtils.on($G("J_searchName"),"keyup",function(e){13==(window.event||e).keyCode&&s.dosearch()}),domUtils.on($G("J_searchBtn"),"click",function(){s.dosearch()})},callback:function(e){var s=this;s.data=e.song_list,setTimeout(function(){$G("J_resultBar").innerHTML=s._renderTemplate(e.song_list)},300)},dosearch:function(){t=null;var e=$G("J_searchName").value;if(""==utils.trim(e))return!1;e=encodeURIComponent(e),this._sent(e)},doselect:function(e){"object"==typeof e?t=e:"number"==typeof e&&(t=this.data[e])},onpageclick:function(e){for(var s=0;s<o.length;s++)$G(o[s]).className="pageoff",$G(p[s]).className="paneloff";$G("page"+e).className="pageon",$G("panel"+e).className="panelon"},listenTest:function(e){var s=this,t=$G("J_preview"),a="m-try"==e.className,n=s._getTryingElem();n&&(n.className="m-try",t.innerHTML=""),a&&(e.className="m-trying",t.innerHTML=s._buildMusicHtml(s._getUrl(!0)))},_sent:function(e){$G("J_resultBar").innerHTML='<div class="loading"></div>',utils.loadFile(document,{src:this.dataUrl+"&query="+e+"&page_size="+this.total+"&callback=music.callback&.r="+Math.random(),tag:"script",type:"text/javascript",defer:"defer"})},_removeHtml:function(e){return e.replace(/<\s*\/?\s*[^>]*\s*>/gi,"")},_getUrl:function(e){var s=this,e="from=tiebasongwidget&url=&name="+encodeURIComponent(s._removeHtml(t.title))+"&artist="+encodeURIComponent(s._removeHtml(t.author))+"&extra="+encodeURIComponent(s._removeHtml(t.album_title))+"&autoPlay="+e+"&loop=true";return s.playerUrl+"?"+e},_getTryingElem:function(){for(var e=$G("J_listPanel").getElementsByTagName("span"),s=0;s<e.length;s++)if("m-trying"==e[s].className)return e[s];return null},_buildMusicHtml:function(e){var s='<embed class="BDE_try_Music" allowfullscreen="false" pluginspage="http://www.macromedia.com/go/getflashplayer"';return s+=' src="'+e+'"',s+=' width="1" height="1" style="position:absolute;left:-2000px;"',s+=' type="application/x-shockwave-flash" wmode="transparent" play="true" loop="false"',s+=' menu="false" allowscriptaccess="never" scale="noborder">'},_byteLength:function(e){return e.replace(/[^\u0000-\u007f]/g,"aa").length},_getMaxText:function(e){return e=this._removeHtml(e),12<this._byteLength(e)?e.substring(0,5)+"...":e=e||"&nbsp;"},_rebuildData:function(e){for(var s,t=[],a=this.pageSize,n=0;n<e.length;n++)(n+a)%a==0&&(s=[],t.push(s)),s.push(e[n]);return t},_renderTemplate:function(e){var s=this;if(0==e.length)return'<div class="empty">'+lang.emptyTxt+"</div>";e=s._rebuildData(e);var t=[],a=[],n=[];t.push('<div id="J_listPanel" class="listPanel">'),a.push('<div class="page">');for(var i,l=0;i=e[l++];){p.push("panel"+l),o.push("page"+l),1==l?(t.push('<div id="panel'+l+'" class="panelon">'),1!=e.length&&n.push('<div id="page'+l+'" onclick="music.onpageclick('+l+')" class="pageon">'+l+"</div>")):(t.push('<div id="panel'+l+'" class="paneloff">'),n.push('<div id="page'+l+'" onclick="music.onpageclick('+l+')" class="pageoff">'+l+"</div>")),t.push('<div class="m-box">'),t.push('<div class="m-h"><span class="m-t">'+lang.chapter+'</span><span class="m-s">'+lang.singer+'</span><span class="m-z">'+lang.special+'</span><span class="m-try-t">'+lang.listenTest+"</span></div>");for(var r,c=0;r=i[c++];)t.push('<label for="radio-'+l+"-"+c+'" class="m-m">'),t.push('<input type="radio" id="radio-'+l+"-"+c+'" name="musicId" class="m-l" onclick="music.doselect('+(s.pageSize*(l-1)+(c-1))+')"/>'),t.push('<span class="m-t">'+s._getMaxText(r.title)+"</span>"),t.push('<span class="m-s">'+s._getMaxText(r.author)+"</span>"),t.push('<span class="m-z">'+s._getMaxText(r.album_title)+"</span>"),t.push('<span class="m-try" onclick="music.doselect('+(s.pageSize*(l-1)+(c-1))+');music.listenTest(this)"></span>'),t.push("</label>");t.push("</div>"),t.push("</div>")}return n.reverse(),a.push(n.join("")),t.push("</div>"),a.push("</div>"),t.join("")+a.join("")},exec:function(){null!=t&&($G("J_preview").innerHTML="",editor.execCommand("music",{url:this._getUrl(!1),width:400,height:95}))}}}();