function $(id) {
    return typeof id == "string" ? document.getElementById(id) : id
}
function isUndefined(variable) {
    return typeof variable == 'undefined' ? true : false
}


//获取时间
function getLocalTime() {
    var date = new Date();

    function addZeros(value, len) {
        var i;
        value = "" + value;
        if (value.length < len) {
            for (i = 0; i < (len - value.length); i++) value = "0" + value
        }
        return value
    }
    return addZeros(date.getHours(), 2) + ':' + addZeros(date.getMinutes(), 2) + ':' + addZeros(date.getSeconds(), 2)
}


//初始化
function initObj() {
	jx.init({});
	return false
    //if (!eMyCrighter || !eMyCrighter.innerHTML.match(re1) || !eMyCrighter.innerHTML.match(re2)) jx = null
}



//enter输入
function ctrlEnter(event) {
    stopFlashTitle();
    if (isUndefined(event)) event = window.event;
    if (event.keyCode == 13 || event.ctrlKey) {
        sending()
    }
    return false
}



//发送信息
function sending() {
    if (sys_status == 0 || sys_status == 2 || is_online == 0 || is_banned == 1 || kickout == 1) return;
    if (lock == 0) {
        var ajaxLine = eMessage.value.replace(/(^\s+)|\s+$/g, "").replace(/\^\^\^|\|\|\|/g, "");
        if (ajaxLine.length > 0) {
            ajaxLine = ajaxLine.replace(/\?/g, '%3F').replace(/&/g, '%26').replace(/\+/g, '%2B').replace(/\r\n|\n|\r/g, "<br>");
            var url = "waiting.php?act=sending&ajaxline=" + ajaxLine + "&ajaxbiu=" + ajaxB + ajaxI + ajaxU + "&ajaxcolor=" + ajaxC;
            ajax(url);
            autoOffline()
        }
        eMessage.value = ""
    }
    setFocus()
}
//对话框弹出信息
function welive_output(data) {
    lock = 0;
    waiting();
    if (data === 0) {
        setStatus(0);
        return
    }
    setStatus(1);
    var newdata = data;
    newdata = newdata.split('||||||');
    ajax_last = newdata[0];
    newdata = newdata[1];
    if (newdata == 2) {
        setStatus(2);
        return
    }
    if (newdata.match(/kickout\^\^\^/i)) {
        kickout = 1;
        newdata = newdata.replace(/kickout\^\^\^/ig, '0|||' + er_kickout + '|||0|||000|||0^^^')
    }
    if (newdata.match(/offline\^\^\^/i)) {
        if (is_online == 1) {
            is_online = 0;
            newdata = newdata.replace(/offline\^\^\^/ig, '0|||' + username + er_useroffline + '|||0|||000|||0^^^')
        } else {
            return
        }
    } else if (is_online == 0) {
        is_online = 1;
        newdata = '0|||' + username + reonline + '|||1|||000|||0^^^' + newdata
    }
    if (newdata.match(/banned\^\^\^/i)) {
        if (is_banned == 0) {
            is_banned = 1;
            newdata = newdata.replace(/banned\^\^\^/ig, '0|||' + er_banned + '|||0|||000|||0^^^')
        } else {
            newdata = newdata.replace(/banned\^\^\^/ig, '')
        }
    } else if (is_banned == 1) {
        is_banned = 0;
        newdata = '0|||' + unbanned + '|||1|||000|||0^^^' + newdata
    }
    if (newdata.length > 18) {
        var aline, time, sender, msg, stype, content, ctype, biu, color, style;
        var lines = newdata.split('^^^');
        newdata = "";
        var do_flashTitle = true;
        for (var i = 0; i < lines.length; i++) {
            aline = lines[i].split('|||');
            if (aline[1]) {
                time = "<span class=time>" + getLocalTime() + "</span>";
                stype = aline[0];
                content = format_output(aline[1]);
                ctype = aline[2];
                biu = aline[3];
                color = aline[4];
                style = '';
                if (color != 0) style = "color:#" + color + ";";
                if (biu.match(/1\d\d/i)) style += "font-weight:bold;";
                if (biu.match(/\d1\d/i)) style += "font-style:italic;";
                if (biu.match(/\d\d1/i)) style += "text-decoration:underline;";
                if (ctype == 2) {
                    msg = "<span style=\"" + style + "\">" + content + "</span>"
                } else {
                    msg = content
                }
                if (stype == 0) {
                    if (ctype == 0) {
                        msg = '<div class="msg e"><div class="msg_b e_bg"><div class="ico"></div><div class="msg_i">' + msg + '</div></div></div>'
                    } else {
                        msg = '<div class="msg i"><div class="msg_b i_bg"><div class="ico"></div><div class="msg_i">' + msg + '</div></div></div>'
                    }
                } else if (stype == 1) {
                    msg = '<div class="msg o"><div class="pip"></div><div class="msg_b o_bg"><div class="msg_i">' + msg + '</div></div><div class="msg_t">' + time + '</div></div>'
                } else if (stype == 2) {
                    msg = '<div class="msg g"><div class="pip"></div><div class="msg_b g_bg"><div class="msg_i">' + msg + '</div></div><div class="msg_t">' + time + '</div></div>';
                    do_flashTitle = false
                }
                newdata = newdata + msg + '<div class="clear"></div>'
            }
        }
        eHistory.innerHTML = eHistory.innerHTML + newdata;
        if (allow_sound == 1 && do_flashTitle) {
            eSounder.innerHTML = sound
        }
        if (do_flashTitle) flashTitle();
        eHistory.scrollTop = eHistory.scrollHeight;
        window.focus();
        setFocus()
    }
}
function format_output(data) {
    data = data.replace(/((href=\"|\')?(((https?|ftp):\/\/)|www\.)([\w\-]+\.)+[\w\.\/=\?%\-&~\':+!#]*)/ig, function($1) {
        return getURL($1)
    });
    data = data.replace(/([\-\.\w]+@[\.\-\w]+(\.\w+)+)/ig, '<a href="mailto:$1" target="_blank">$1</a>');
    data = data.replace(/\[:(\d*):\]/g, '<img src="' + t_url + 'smilies/$1.gif">');
    return data
}
function getURL(url) {
    if (url.substr(0, 5).toLowerCase() == 'href=') return url;
    var urllink = '<a href="' + (url.substr(0, 4).toLowerCase() == 'www.' ? 'http://' + url : url) + '" target="_blank" title="' + url + '">';
    if (url.length > 60) {
        url = url.substr(0, 30) + ' ... ' + url.substr(url.length - 18)
    }
    urllink += url + '</a>';
    return urllink
}


_attachEvent(document, 'mousedown', stopFlashTitle);