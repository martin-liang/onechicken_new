function loadRegion(sel, type_id, selName, url) {
    jQuery("#" + selName + " option").each(function() {
        jQuery(this).remove();
    });
    jQuery("<option value=''>请选择</option>").appendTo(jQuery("#" + selName));
    if (jQuery("#" + sel).val() == 0) {
        return;
    }
    jQuery.getJSON(url, {pid: jQuery("#" + sel).val(), type: type_id},
    function(data) {
        if (data) {
            jQuery.each(data, function(idx, item) {
                jQuery("<option value=" + item.id + ">" + item.name + "</option>").appendTo(jQuery("#" + selName));
            });
        } else {
            jQuery("<option value=''>请选择</option>").appendTo(jQuery("#" + selName));
        }
    }
    );
}

//联动小区
function loadXiaoqu(sel,type_id,selName,url){
	jQuery("#"+selName+" option").each(function(){
		jQuery(this).remove();
	});
	jQuery("<option value=''>请选择</option>").appendTo(jQuery("#"+selName));
	if(jQuery("#"+sel).val()==0){
		return;
	}
	jQuery.getJSON(url,{pid:jQuery("#"+sel).val(),type:type_id},
		function(data){
			if(data){
				jQuery.each(data,function(idx,item){
					jQuery("<option value="+item.xid+">"+item.name+"</option>").appendTo(jQuery("#"+selName));
				});
			}else{
				jQuery("<option value=''>请选择</option>").appendTo(jQuery("#"+selName));
			}
		}
	);
}


function loadXiaoqu2(selName, sel,url) {
    jQuery("#" + selName + " option").each(function() {
        jQuery(this).remove();
    });
    if (jQuery("#" + sel).val() == 0) {
        return;
    }
    jQuery.post(url, {area: jQuery("#" + sel).val()},
    function(data) {
        if (data) {
            jQuery.each(data, function(idx, item) {
                jQuery("<option value=" + item.xid + ">" + item.name + "</option>").appendTo(jQuery("#" + selName));
            });
        } else {
            jQuery("<option value='0'>没找到小区</option>").appendTo(jQuery("#" + selName));
        }
    }
    );
}
function loadXiaoqu3(selName, sel,url) {
	$("#customers_qy").empty();
    jQuery("#" + selName + " option").each(function() {
        jQuery(this).remove();
    });
    if (jQuery("#" + sel).val() == 0) {
        return;
    }
    jQuery.post(url, {area: jQuery("#" + sel).val()},
    function(data) {
        if (data) {
            jQuery.each(data, function(idx, item) {
            	$("#customers_qy").append("<li><input type='checkbox' name='xiaoqu[]' value='"+item.id+"' />&nbsp;"+item.name+"&nbsp;&nbsp;</li>");
            	//jQuery("<option value=" + item.xid + ">" + item.name + "</option>").appendTo(jQuery("#" + selName));
                //jQuery("<option value=" + item.xid + ">" + item.name + "</option>").appendTo(jQuery("#" + selName));
            });
        } else {
        	$("#customers_qy").append("没找到小区");
        }
    }
    );
}