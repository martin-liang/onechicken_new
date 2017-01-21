function setHeadUserStatus() {
    $.ajax({
        type: "POST",
        url: "/Backend/Ajax/checklogin",
        dataType:'json',
        success: function(data) {
            if (data.s == 1) {
                $("#nickname")[0].innerHTML = data.u;
                $("#rolename")[0].innerHTML = data.r;
                $("#ltime")[0].innerHTML = data.t;
            } else {
                window.location.href = "/Backend/Index/index";
            }
        }
    })
}

function choosecate() {
    var level = $("#level").val();
    var type = $("#type").val();
    if (level != 1) {
        $.ajax({
            type: "POST",
            url: "/Backend/Ajax/catefilter",
            data: "level=" + level + "&type=" + type + "&style=1",
            success: function(result) {
                $("#ajax_result")[0].innerHTML = result;
            }
        })
    } else if (level == 1) {
        $("#ajax_result")[0].innerHTML = '一级分类不存在上级分类';
    }
}

function subcate() {
    var pid = $("#pid").val();
    if (pid != 0) {
        $.ajax({
            type: "POST",
            url: "/Backend/Ajax/subcate",
            data: "pid=" + pid + "&style=2",
            success: function(result) {
                $("#category option:not(:first)").remove();
                $("#category").append(result);
            }
        })
    }
}

function chooseSubAction(aid, node) {
    if (aid != 0) {
        $.ajax({
            type: "POST",
            url: "/Backend/Ajax/subAction",
            data: "aid=" + aid + '&node=' + node,
            success: function(result) {
                var node = result.split("|")[0];
                var con = result.split("|")[1];
                $("select[id^=" + node + "_]").remove();//清理所有子功能
                $("#" + node).after(con);
            }
        })
    }
}

//验证分类编码是否唯一
function checkCateCode(code) {
    if (code == '') {
        $("#submit").hide();
        $("#ajax_result_code")[0].innerHTML = '错误，分类英文名称不能为空';
        return;
    }
    $.ajax({
        type: "POST",
        url: "/Backend/Ajax/checkCateCode",
        data: 'code=' + code,
        success: function(result) {
            if (result == 1) {
                $("#submit").show();
                $("#ajax_result_code")[0].innerHTML = 'OK，该英文名称可以添加';
            } else {
                $("#submit").hide();
                $("#ajax_result_code")[0].innerHTML = '错误，该英文名称不可以添加';
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
                    url: "/Backend/Ajax/changePwd",
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
