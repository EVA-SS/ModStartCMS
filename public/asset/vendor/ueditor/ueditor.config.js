!function(){var e,t;function o(e,t){return function(e,t){var o=t;/^(\/|\\\\)/.test(t)?o=/^.+?\w(\/|\\\\)/.exec(e)[0]+t.replace(/^(\/|\\\\)/,""):/^[a-z]+:/i.test(t)||(e=e.split("#")[0].split("?")[0].replace(/[^\\\/]+$/,""),o=e+""+t);return function(e){var t=/^[a-z]+:\/\//.exec(e)[0],o=null,l=[];(e=(e=e.replace(t,"").split("?")[0].split("#")[0]).replace(/\\/g,"/").split(/\//))[e.length-1]="";for(;e.length;)".."===(o=e.shift())?l.pop():"."!==o&&l.push(o);return t+l.join("/")}(o)}(e||self.document.URL||self.location.href,t||(t=document.getElementsByTagName("script"))[t.length-1].src)}e=window.UEDITOR_HOME_URL||(window.__msCDN?window.__msCDN+"asset/vendor/ueditor/":window.__msRoot?window.__msRoot+"asset/vendor/ueditor/":o()),t=window.__msRoot?window.__msRoot+"asset/vendor/ueditor/":o(),window.UEDITOR_CONFIG={UEDITOR_HOME_URL:e,UEDITOR_CORS_URL:t,serverUrl:"/ueditor-plus/_demo_server/handle.php",toolbars:[["fullscreen","source","|","undo","redo","|","bold","italic","underline","fontborder","strikethrough","superscript","subscript","removeformat","formatmatch","autotypeset","blockquote","pasteplain","|","forecolor","backcolor","insertorderedlist","insertunorderedlist","selectall","cleardoc","|","rowspacingtop","rowspacingbottom","lineheight","|","customstyle","paragraph","fontfamily","fontsize","|","directionalityltr","directionalityrtl","indent","|","justifyleft","justifycenter","justifyright","justifyjustify","|","touppercase","tolowercase","|","link","unlink","anchor","|","imagenone","imageleft","imageright","imagecenter","|","simpleupload","insertimage","emotion","scrawl","insertvideo","attachment","insertframe","insertcode","pagebreak","template","background","formula","|","horizontal","date","time","spechars","wordimage","|","inserttable","deletetable","insertparagraphbeforetable","insertrow","deleterow","insertcol","deletecol","mergecells","mergeright","mergedown","splittocells","splittorows","splittocols","|","print","preview","searchreplace","help"]],toolbarCallback:function(e,t){},imageConfig:{disableUpload:!1,disableOnline:!1,selectCallback:null},videoConfig:{disableUpload:!1,selectCallback:null},formulaConfig:{imageUrlTemplate:"https://latex.codecogs.com/svg.image?{}"},autoSaveEnable:!0,autoSaveRestore:!1,autoSaveKey:null,initialContent:"",focus:!1,initialStyle:"",indentValue:"2em",readonly:!1,autoClearEmptyNode:!0,fullscreen:!1,allHtmlEnabled:!1,enableContextMenu:!0,shortcutMenu:["fontfamily","fontsize","bold","italic","underline","strikethrough","fontborder","forecolor","justifyleft","justifycenter","justifyright","justifyjustify","lineheight","insertorderedlist","insertunorderedlist","superscript","subscript","link","unlink","touppercase","tolowercase"],elementPathEnabled:!0,wordCount:!0,maximumWords:1e4,maxUndoCount:20,maxInputCount:1,autoHeightEnabled:!0,catchRemoteImageEnable:!0,autotypeset:{mergeEmptyline:!0,removeClass:!0,removeEmptyline:!1,textAlign:"left",imageBlockLine:"center",pasteFilter:!1,clearFontSize:!1,clearFontFamily:!1,removeEmptyNode:!1,removeTagNames:{div:1},indent:!1,indentValue:"2em",bdc2sb:!1,tobdc:!1},allowDivTransToP:!0,rgb2Hex:!0},window.UE={getUEBasePath:o}}();