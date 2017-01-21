function setHeadUserStatus() {
    $.ajax({
        type: "POST",
        url: "/Fuwu/Index/checklogin",
        dataType:'json',
        success: function(data) {
            if (data.s == 1) {
				$('#nickname').html(data.u);
				$('#rolename').html(data.r);
				$('#ltime').html(data.t);
              //  $("#nickname")[0].innerHTML = data.u;
              //  $("#rolename")[0].innerHTML = data.r;
              //  $("#ltime")[0].innerHTML = data.t;
            } else {
                window.location.href = "/Fuwu/Index/index";
            }
        }
    })
}



function changePwd(id) {
    var txt = '请输入原密码：<input type="password" id="pwd_o" name="opwd" value="" class="text-input"/><br/>';
    txt += '请输入新密码：<input type="password" id="pwd_n" name="npwd" value="" class="text-input"/><br/>';
    txt += '请重复新密码：<input type="password" id="pwd_c" name="cpwd" value="" class="text-input"/><br/>';
    $.prompt(txt, {
        buttons: {
            提交: true,
            取消: false
        },
        callback: function(v, m, f) {
            if (v) {
                var opwd = m.find("#pwd_o")[0].value;
                var npwd = m.find("#pwd_n")[0].value;
                var cpwd = m.find("#pwd_c")[0].value;
                $.ajax({
                    type: "POST",
                    url: "/Fuwu/Index/changePwd",
                    data: "id=" + id + "&opwd=" + opwd + "&npwd=" + npwd + '&cpwd=' + cpwd,
                    success: function(result) {
                        var da = eval('(' + result + ')');
                        $.prompt(da.msg, {
                            show: 'slideDown'
                        });
                    }
                })
            }
        }
    });
}
