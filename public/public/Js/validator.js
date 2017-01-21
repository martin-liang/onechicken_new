$(document).ready(function () {
	$(".form-horizontal").submit(function(){
		is_submit=1;
		var focus_arr=Array();
		var arr_index=0;
		//下拉框验证

		$('.va_select').each(function(index){
			if($(this).val() == ""){
				$(this).parent().children(".help-block").html("请选择列表中的一项");
				focus_arr[arr_index]=$(this);
				++arr_index;
				is_submit=0;
			}
		});
		
		//文本域验证
		$('.va_input_text').each(function(index){
			if($.trim($(this).val()) == ""){
				$(this).parent().children(".help-block").fadeIn(2000,function(){
					$(this).parent().children(".help-block").html("此项不能为空");
				});
				focus_arr[arr_index]=$(this);
				++arr_index;
				is_submit=0;
			}

		});
		//验证电话
		var va_input_tel = $(".va_input_tel");
		$('.va_input_tel').each(function(index){
            var phone_str=$(this).val();
            phone_str=phone_str.replace(/(^\s*)|(\s*$)/g, "")
            $(this).val(phone_str);
            if($(this).val().length > 15){
				$(this).parent().children(".help-block").fadeIn(2000,function(){
					$(this).parent().children(".help-block").html("此项限制15个字符");
				});
				focus_arr[arr_index]=$(this);
				++arr_index;
				is_submit=0;
			}
			
			var isMobile=/^(?:13\d|17\d|15\d|14\d|18\d)\d{5}(\d{3}|\*{3})$/; 
			var isPhone=/^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;

			 if(!isMobile.test($(this).val()) && !isPhone.test($(this).val())){
				$(this).parent().children(".help-block").html("请正确填写电话号码，例如:13415764179或0321-4816048");
			    focus_arr[arr_index]=$(this);
				++arr_index;
				is_submit=0;
			 }
		});
		//验证只能输入数字
		$('.va_input_math').each(function(index){
			if($(this).val() != ""){
				var reg_keleyi_com = /^[-+]?\d+$/;
				if (!reg_keleyi_com.test($(this).val())) {
					$(this).parent().children(".help-block").html("此项只能输入数字");
					focus_arr[arr_index]=$(this);
					++arr_index;
					is_submit=0;
				}
			}
		});
		
		//验证数字和浮点数
		$('.va_input_math_float').each(function(index){
			var reg_keleyi_float = /^\d+(\.\d+)?$/;
			if($(this).val() != ""){
				if(!reg_keleyi_float.test($(this).val())){
					$(this).parent().children(".help-block").html("此项只能输入数字和小数");
					focus_arr[arr_index]=$(this);
					++arr_index;
					is_submit=0;
				}
			}
		});
		
		//验证输入字符限制，2~16位
		$('.va_input_length_2_16').each(function(index){
			if($(this).val() != ""){
				if($(this).val().length < 2 || $(this).val().length > 16){
					$(this).parent().children(".help-block").html("此项限制2-16个字符");
					focus_arr[arr_index]=$(this);
					++arr_index;
					is_submit=0;
				}
			}
		});
		//验证输入字符限制，5~60位
		$('.va_input_length_5_60').each(function(index){
			if($(this).val() != ""){
				if($(this).val().length < 5 || $(this).val().length > 60){
					$(this).parent().children(".help-block").html("此项限制5-60个字符");
					focus_arr[arr_index]=$(this);
					++arr_index;
					is_submit=0;
				}
			}
		});
		
			//验证层高
		var ceng1 = $("#ceng1").val();
		var ceng2 = $("#ceng2").val();
		if(ceng1 != "" && ceng2 != ""){
			if(parseInt(ceng1) > parseInt(ceng2)){
				$("#ceng1").parent().children(".help-block").html("当前楼层不能高于总楼层");
			}
		}
		
		//验证图片是否为空
		var va_imglist = $(".va_imglist");
		if(va_imglist.val() == "" || va_imglist.val() == "||"){
			$("#thumbnails").parent().children(".help-block").html("请上传图片");
		}
		
		
		if(is_submit==0){
		//	focus_arr[0].focus();
			return false;
		}
	});
	$("input").focus(function(){
		$(this).parent().children(".help-block").html("");
	});
	$("select").focus(function(){
		$(this).parent().children(".help-block").html("");
	});
});