/*通用头部[用户中心]hover*/
var popupStatus = 0;
$(document).ready(function() {
    setHeadUserStatus();// 检测是否登录
    $("#datepicker1").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear:true,
        changeMonth:true,
        yearRange:"1900:2050",
        //numberOfMonths: 2, //显示几个月
        monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
        dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
        dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
        dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );  
            $( "<button>", {  
              text: "清除",
              class:"ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all",
              click: function() {  
                $.datepicker._clearDate( input );  
              }  
            }).appendTo( buttonPane );  
          }, 1 );  
        }
    });
    $("#datepicker2").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear:true,
        changeMonth:true,
        yearRange:"1900:2050",
        //numberOfMonths: 2, //显示几个月
        monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
        dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
        dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
        dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );  
            $( "<button>", {  
              text: "清除",
              class:"ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all",
              click: function() {  
                $.datepicker._clearDate( input );  
              }  
            }).appendTo( buttonPane );  
          }, 1 );  
        }
    });
    $("#datepicker3").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear:true,
        changeMonth:true,
        yearRange:"1900:2050",
        //numberOfMonths: 2, //显示几个月
        monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
        dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
        dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
        dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );  
            $( "<button>", {  
              text: "清除",
              class:"ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all",
              click: function() {  
                $.datepicker._clearDate( input );  
              }  
            }).appendTo( buttonPane );  
          }, 1 );  
        }
    });
    $("#datepicker4").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear:true,
        changeMonth:true,
        yearRange:"1900:2050",
        minDate:0,
        //numberOfMonths: 2, //显示几个月
        monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
        dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
        dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
        dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );  
            $( "<button>", {  
              text: "清除",
              class:"ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all",
              click: function() {  
                $.datepicker._clearDate( input );  
              }  
            }).appendTo( buttonPane );  
          }, 1 );  
        }
    });
	$("#datepicker5").datetimepicker({
    	  changeYear:true,
        changeMonth:true,
        timeFormat: "HH:mm:ss",
        dateFormat: "yy-mm-dd",
        showSecond: true,
        numberOfMonths:1,
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );  
			  buttonPane.find("button:eq(0)").click(function(){
						//$.datepicker._clearDate(input);
						$("#datepicker5").blur();
			});
            $( "<button>", {  
              text: "清除",
              class:"ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all",
              click: function() {  
                $.datepicker._clearDate( input );  
              }  
            }).appendTo( buttonPane );  
          }, 1 );  
        }
    });
	
    $(function() {
        $("[data-toggle='tooltip']").tooltip();
    });
});

function comfirmOper(txt, url, is_self) {
    var msg = '您确定要' + txt + '?';
    $.prompt(msg, {
        buttons: {
            '确认': true,
            '取消': false,
        },
        callback: function(v, m, f) {
            if (v) {
                if (is_self == 1) {
                    window.open(url);
                } else {
                    window.location.href = url;
                }
            }
        }
    });
}

//refresh imgcode
function getimgcode() {
    var randomnum = Math.random();
    var getimagecode = document.getElementById("getcode");
    getimagecode.src = "randcode.php?" + randomnum;
}

function checkNum(a) {
    if (isNaN(a.value)) {
        a.value = "";
    }
}