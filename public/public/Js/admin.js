$(document).ready(function () { 
    $("#datepicker1").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear:true,
        changeMonth:true,
        yearRange:"1900:2050",
       // numberOfMonths:2,//显示几个月
        monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );  
			 buttonPane.find("button:eq(0)").click(function(){
						//$.datepicker._clearDate(input);
						$("#datepicker1").blur();
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
    
    $("#datepicker2").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear:true,
        changeMonth:true,
       // numberOfMonths:2,//显示几个月
        monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );
			  buttonPane.find("button:eq(0)").click(function(){
						//$.datepicker._clearDate(input);
						$("#datepicker2").blur();
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
    $("#datepicker3").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear:true,
        changeMonth:true,
       // numberOfMonths:2,//显示几个月
        monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );
			buttonPane.find("button:eq(0)").click(function(){
						//$.datepicker._clearDate(input);
						$("#datepicker3").blur();
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
    $("#datepicker4").datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear:true,
        changeMonth:true,
      //  numberOfMonths:2,//显示几个月
        monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );  
			  buttonPane.find("button:eq(0)").click(function(){
						//$.datepicker._clearDate(input);
						$("#datepicker4").blur();
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
    $("#datepicker6").datetimepicker({
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
						$("#datepicker6").blur();
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
    $("#datepicker7").datetimepicker({
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
						$("#datepicker7").blur();
			});
          }, 1 );  
        }
    });
    $("#datepicker8").datetimepicker({
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
						$("#datepicker8").blur();
			});
          }, 1 ); 
		}
    });

    $("#datepicker9").datetimepicker({
        timeFormat: "HH:mm:ss",
        dateFormat: "yy-mm-dd",
        showSecond: true,
        numberOfMonths:1,
        minDate:0,
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" ); 
			buttonPane.find("button:eq(0)").click(function(){
						$.datepicker._clearDate(input);
						$("#datepicker9").blur();
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
    $("#datepicker10").datetimepicker({
        timeFormat: "HH:mm:ss",
        dateFormat: "yy-mm-dd",
        showSecond: true,
        numberOfMonths:1,
        minDate:0,
        showButtonPanel: true,
        beforeShow: function( input ) { 
          setTimeout(function() {  
            var buttonPane = $( input )  
              .datepicker( "widget" )  
              .find( ".ui-datepicker-buttonpane" );  
			  buttonPane.find("button:eq(0)").click(function(){
						//$.datepicker._clearDate(input);
						$("#datepicker10").blur();
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

$("#datepicker11").datepicker({
        dateFormat: 'yy-mm',
        changeYear:true,
        changeMonth:true,
        // numberOfMonths:2,//显示几个月
        monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        showButtonPanel: true,
        beforeShow: function( input ) {
			$("#ui-datepicker-div").remove();
            setTimeout(function() {
                var buttonPane = $( input )
                    .datepicker( "widget" )
                    .find( ".ui-datepicker-buttonpane" );
					buttonPane.find("button:eq(0)").click(function(){
						//$.datepicker._clearDate(input);
						$("#datepicker11").blur();
			});
                $( "<button>", {
                    text: "清除",
                    class:"ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all",
                    click: function() {
                        $.datepicker._clearDate( input );
                    }
                }).appendTo( buttonPane );
            }, 1 );
			setTimeout(function(){
				$(".ui-datepicker-calendar").removeClass("ui-datepicker-calendar1");
			},1);
        }
    });
    $("#datepicker12").datepicker({
        dateFormat: 'yy-mm',
        changeYear:true,
        changeMonth:true,
        // numberOfMonths:2,//显示几个月
        monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        showButtonPanel: true,
        beforeShow: function( input ) {
			$("#ui-datepicker-div").remove();
            setTimeout(function() {
                var buttonPane = $( input )
                    .datepicker( "widget" )
                    .find( ".ui-datepicker-buttonpane" );
					buttonPane.find("button:eq(0)").click(function(){
						//$.datepicker._clearDate(input);
						$("#datepicker12").blur();
			});
                $( "<button>", {
                    text: "清除",
                    class:"ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all",
                    click: function() {
                        $.datepicker._clearDate( input );
                    }
                }).appendTo( buttonPane );
            }, 1 );
			setTimeout(function(){
				$(".ui-datepicker-calendar").removeClass("ui-datepicker-calendar1");
			},1);
        }
    });

});