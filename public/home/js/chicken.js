/*
 * create by zhe-he
 * e-mail: luanhong_feiguo@sina.com
 * 
 */

var userid = getCookie("user_id") || getCookie("userid");
var qian = window.location.hash;

if (!userid) {
	window.location.reload();
}

new Vue({
	el: "#chicken",
	data: {
		iswaiting: true,
		c_money: 50,
		t_money: '',
		tx_name: '',
		tx_card: '',
		tx_tel: '',
		is_tx: false,
		t_timer: null, 	// 弹窗时间控制器
		a_message: { 	// 弹窗
			font: '',
			isStatus: 1,
			isClose: true
		},
		isMenuCz: 0, 	// 充值菜单
		isGuize: false,  // 规则弹窗
		isTuijian: false,　// 推荐弹窗
		j_data: { 		// 用户的鸡蛋数据
			ji: 0,
			dan: 0,
			di: 1,
			friend: 0,
			all_money: 0
		},
		recommand_list: [],
		tian: []
	},
	mounted: function (){
		var _this = this;
		ajax({
			url: "/api/info",
			data: {
				"userid": userid
			},
			type: "post",
			success: function (message){
				_this.iswaiting = false;
				message = eval('('+message+')');
				var data = message.data;

				if (/^#qian\=[\d\.]+$/.test(qian)) {
					var qq = qian.substr(6);
					_this.show_msg(1,'充值'+qq+'元成功');
					window.location.hash = "";
					setTimeout(function(){
						_this.a_message.isClose = true;
						_this.$nextTick(function (){
							_this.show_msg(1,'您已获得'+qq+'只鸡蛋');
						});
						
					},2000);
				}
				

				var j_data = {
					ji: data.chickens-0,
					dan: data.total_eggs-0-data.recommand_eggs,
					di: data.soils-0,
					friend: data.recommand_eggs-0,
					all_money: data.money-0
				};
				var tian = [];
				for (var i = 0; i < data.soil_list.length; i++) {
					var d = data.soil_list[i].enabled=="1";
					var a = data.soil_list[i].henroost_a;
					var b = data.soil_list[i].henroost_b;
					var c = data.soil_list[i].chickens || [];

					tian[i] = {
						"enabled": d,
						"henroost_a": a,
						"henroost_b": b,
						"chickens": c
					}
				}

				
				_this.j_data = j_data;
				_this.tian = tian;
				_this.recommand_list = data.recommand_list.slice(0,8);
				
				
				if (_this.j_data.friend > 0) {
					_this.show_msg(1,'通过你的小伙伴分享，你已获得了'+_this.j_data.friend+'个蛋。');
					_this.j_data.dan += _this.j_data.friend;
					_this.j_data.friend = 0;
				}
					
			},
			error: function (){
				_this.iswaiting = false;
			}
		});

	},
	methods: {
		set_ji_di: function (type){
			if (type == 'ji') {
				for (var i = 0; i < this.tian.length; i++) {
					if (this.tian[i].chickens.length<2) {
						this.tian[i].chickens.push({
							no_get_eggs: "0"
						});
						break;
					}
				}
			}else if(type == 'di'){
				for (var i = 0; i < this.tian.length; i++) {
					if (!this.tian[i].enabled) {
						this.tian[i].enabled = true;
						break;
					}
				}
			}
		},
		copy: function (json){
			return JSON.parse(JSON.stringify(json));
		},
		put_dan: function (j,index,index2){
			var _this = this;
			if (j.no_get_eggs>0) {
				_this.iswaiting = true;
				ajax({
					url: "/api/pickup_eggs",
					data: {
						"userid": userid,
						"chicken_id": j.id,
                        "soil_id": j.soil_id
					},
					type: "post",
					success: function(data){
						_this.iswaiting = false;
						data = eval('('+data+')');
						if (data.status=="false" || data.status==false){
							_this.tian[index].chickens[index2].no_get_eggs = 0;
						} else {
							_this.j_data.dan += 5;
							_this.tian[index].chickens[index2].no_get_eggs = 0;
							
							if (j.is_dead=="1" || j.is_dead=="2") {
								_this.show_msg(0,'很遗憾，你的鸡已不会生蛋了，将告别你。');
								setTimeout(function (){
									window.location.reload();
								},2000);
							}
							
						}
					},
					error: function (){
						_this.iswaiting = false;
					}
				})
			}
		},
		show_msg: function (status,font){
			this.a_message.isClose = false;
			this.a_message.isStatus = status;
			this.a_message.message = font;
		},
		show_menu_cz: function (num){
			this.isMenuCz = num;
		},
		mai:function(item,bool){
			var _this = this;
			if (item.enabled) {
				if (item.chickens.length<2) {
					if (!bool && item.chickens.length==1 && item.chickens[0].no_get_eggs>0) {return };
					if (window.confirm('是否花100只蛋买一只鸡?')) {
						
						if (this.j_data.dan >= 100) {
							_this.iswaiting = true;
							ajax({
								url: "/api/egg2chicken",
								data: {
									"userid": userid
								},
								type: "post",
								success: function (data){
									_this.iswaiting = false;
									data = eval('('+data+')');
									if (data.status=="false"||data.status==false) {
										_this.show_msg(0,data.msg);
									}else{
										_this.j_data.dan -= 100;
										_this.j_data.ji += 1;
										_this.show_msg(1,'你已拥有一只超生产力的母鸡！');
										_this.set_ji_di('ji');
									}
									
								},
								error: function (){
									_this.iswaiting = false;
								}
							});
							
						}else{
							this.show_msg(0,'鸡蛋不足，无法购买');
						}
					}
				}
			}else{
				if (window.confirm('是否花10只蛋买一块地?')) {
					if (this.j_data.dan >= 10) {
						_this.iswaiting = true;
						ajax({
							url: "/api/enable_soil",
							data: {
								"userid": userid
							},
							type: "post",
							success: function (data){
								_this.iswaiting = false;
								data = eval('('+data+')');
								if (data.status=="false"||data.status==false) {
									_this.show_msg(0,data.msg);
								}else{
									_this.j_data.dan -= 10;
									_this.j_data.di += 1;
									_this.show_msg(1,'你已永久拥有一块养鸡的地！');
									_this.set_ji_di('di');
								}
								
								
							},
							error: function (){
								_this.iswaiting = false;
							}
						});
						
					}else{
						this.show_msg(0,'鸡蛋不足，无法购买');
					}
				}
			}
		},
		mai2: function (type){
			if (type == 1) {
				if (this.j_data.ji==20) {return}
				var cur = 0;
				for (var i = 0; i < this.tian.length; i++) {
					if (this.tian[i].chickens.length<2) {
						cur = i;
						break;
					}
				}
				this.mai(this.tian[cur],true);
			}else if(type == 2){
				if (this.j_data.di==10) {return}
				var cur = 0;
				for (var i = 0; i < this.tian.length; i++) {
					if (!this.tian[i].enabled) {
						cur = i;
						break;
					}
				}
				this.mai(this.tian[cur],true);
			}
		},
		cz: function(item){
			var _this = this;
			this.isMenuCz = item;
			if (item == 1) {
				var t2 = Math.floor(this.c_money/10) != Math.ceil(this.c_money/10);
				if(t2){
					this.show_msg(0,'请按10的倍数进行充值');
				}else if(this.c_money < 10){
					this.show_msg(0,'最少充值10元');
				}else if (window.confirm('充值'+this.c_money+'元？')) {
					_this.iswaiting = true;
					
					window.location.href = "/api/pay?userid="+userid+"&money="+this.c_money;

				}
			}else if(item == 2){
				this.is_tx = true;

			}
		},
		tx: function(){
			var _this = this;
			var t2 = Math.floor(this.t_money/10) != Math.ceil(this.t_money/10);
			if (this.j_data.dan < this.t_money) {
				this.show_msg(0,'鸡蛋不足'+this.t_money+'个,无法提现');
			}else if(this.t_money < 10){
				this.show_msg(0,'最少提现10个鸡蛋');
			}else if(t2){
				this.show_msg(0,'请按10个蛋的倍数进行提现');
			}else{
				if (!this.tx_name) {
					this.show_msg(0,'请填写姓名');
					return ;
				}
				if (!/^1[3-9]\d{9}$/.test(this.tx_tel)) {
					this.show_msg(0,'请填写正确的手机号码');
					return ;
				}
				if (!/^\d{8,24}$/.test(this.tx_card)) {
					this.show_msg(0,'请填写正确的银行卡号');
					return ;
				}
				_this.iswaiting = true;
				ajax({
					url: "/api/tixian",
					data: {
						"userid": userid,
						"name": this.tx_name,
						"money": this.t_money,
						"phone": this.tx_tel,
						"brank_num": this.tx_card
					},
					type: "post",
					success: function (data){
						_this.iswaiting = false;
						data = eval('('+data+')');
						if (data.status=="false" || data.status==false) {
							_this.show_msg(0,data.msg);
						}else{
							_this.show_msg(1,'提现'+_this.t_money+'元成功，请等待客服处理');
							_this.j_data.dan -= _this.t_money;
							_this.j_data.all_money += _this.t_money;

							_this.$nextTick(function (){
								_this.t_money = "";
								_this.tx_name = "";
								_this.tx_tel = "";
								_this.tx_card = "";
							});
						}
					},
					error: function (){
						_this.iswaiting = false;
					}
				});
			}
		}
	}
})


function getCookie(e)
{
	for(var t=document.cookie,i=t.split("; "),n=0;n<i.length;n++){
		var a=i[n].split("=");
		if(a[0]==e)return unescape(a[1])
	}
	return ""
}

function getLocationSearch(url){
    if (!!url) {
        var search = url.substring(url.indexOf('?'));
    }else{
        var search = window.location.search || '?';
    }
    var arr1 = search.substring(1).split('&');
    var json = {};
    for (var i = 0; i < arr1.length; i++) {
        var arr2 = arr1[i].split('=');
        if (!json[arr2[0]]) {
            json[arr2[0]] = arr2[1];
        }
    }
    return json
}

function getUrlData(name){
    var json = getLocationSearch();
    var str = json[name] || '';
    return str
}