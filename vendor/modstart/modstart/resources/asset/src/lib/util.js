var Util = {};

Util.specialchars = function (str) {
    var s = [];
    if (!str) {
        return '';
    }
    if (str.length == 0) {
        return '';
    }
    for (var i = 0; i < str.length; i++) {
        switch (str.substr(i, 1)) {
            case "<":
                s.push("&lt;");
                break;
            case ">":
                s.push("&gt;");
                break;
            case "&":
                s.push("&amp;");
                break;
            case " ":
                s.push("&nbsp;");
                break;
            case "\"":
                s.push("&quot;");
                break;
            default:
                s.push(str.substr(i, 1));
                break;
        }
    }
    return s.join('');
};

Util.text2html = function (str) {
    str = Util.specialchars(str);
    str = str.replace(/\n/g, '</p><p>');
    return '<p>' + str + '</p>';
};

Util.text2paragraph = function (str) {
    str = str.replace(/\n/g, '</p><p>');
    return '<p>' + str + '</p>';
};

Util.urlencode = function (str) {
    str = (str + '').toString();
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
};

Util.randomString = function randomString(len) {
    len = len || 16;
    var $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var maxPos = $chars.length;
    var pwd = '';
    for (var i = 0; i < len; i++) {
        pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return pwd;
};

Util.getRootWindow = function () {
    var w;
    w = window;
    while (w.self !== w.parent) {
        w = w.parent;
    }
    return w;
};

Util.fixPath = function (path, cdn) {
    cdn = cdn || '';
    if (!path) {
        return '';
    }
    if (path.indexOf('http://') === 0 || path.indexOf('https://') === 0 || path.indexOf('//') === 0) {
        return path;
    }
    if (path.indexOf('/') === 0) {
    } else {
        path = '/' + path;
    }
    if (cdn && (cdn.lastIndexOf('/') == cdn.length - 1)) {
        cdn = cdn.substr(0, cdn.length - 1);
    }
    return cdn + path;
}

Util.objectValue = function (obj, key, value) {
    // console.log('Util.objectValue', key, value)
    if (typeof key == 'string') {
        return Util.objectValue(obj, key.split('.'), value)
    } else if (key.length == 1 && value !== undefined) {
        return obj[key[0]] = value
    } else if (key.length == 0) {
        return obj
    } else {
        if (/^\d+$/.test(key[0])) {
            key[0] = parseInt(key[0])
        }
        return Util.objectValue(obj[key[0]], key.slice(1), value)
    }
}

Util.fullscreen = {
    enter: function (callback) {
        var docElm = document.documentElement;
        //W3C
        if (docElm.requestFullscreen) {
            docElm.requestFullscreen();
            setTimeout(function () {
                callback && callback();
            }, 1000);
        }
        //FireFox
        else if (docElm.mozRequestFullScreen) {
            docElm.mozRequestFullScreen();
            setTimeout(function () {
                callback && callback();
            }, 1000);
        }
        //Chrome等
        else if (docElm.webkitRequestFullScreen) {
            docElm.webkitRequestFullScreen();
            setTimeout(function () {
                callback && callback();
            }, 1000);
        }
        //IE11
        else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
            setTimeout(function () {
                callback && callback();
            }, 1000);
        }
    },
    exit: function (callback) {
        if (document.exitFullscreen) {
            document.exitFullscreen();
            setTimeout(function () {
                callback && callback();
            }, 1000);
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
            setTimeout(function () {
                callback && callback();
            }, 1000);
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
            setTimeout(function () {
                callback && callback();
            }, 1000);
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
            setTimeout(function () {
                callback && callback();
            }, 1000);
        }
    },
    isFullScreen: function () {
        if (document.exitFullscreen) {
            return document.fullscreen;
        } else if (document.mozCancelFullScreen) {
            return document.mozFullScreen;
        } else if (document.webkitCancelFullScreen) {
            return document.webkitIsFullScreen;
        } else if (document.msExitFullscreen) {
            return document.msFullscreenElement;
        }
        return false;
    },
    trigger: function (callback) {
        if (Util.fullscreen.isFullScreen()) {
            Util.fullscreen.exit(function () {
                callback('exit');
            });
        } else {
            Util.fullscreen.enter(function () {
                callback('enter');
            });
        }
    }
};

Util.scrollTo = function (selector) {
    var $target = $(selector);
    if (!$target.length) {
        console.warn('Util.scroll target=( ' + selector + ' ) not found');
        return;
    }
    var top = $target.offset().top;
    $('html,body').animate({scrollTop: top}, 200);
};

module.exports = Util;
