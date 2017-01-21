<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,initial-scale=1.0">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <title>鸡祥如意2017</title>
    <link rel="stylesheet" type="text/css" href="/public/home/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/public/home/css/chicken.css">
    <script type="text/javascript" src="/public/home/js/fastclick.js"></script>
    <script type="text/javascript" src="/public/home/js/autosize.js"></script>
</head>
<body>
<article v-cloak id="chicken" class="main">
    <header class="top">
        <a @click="isGuize=true" href="javascript:;"></a>
        <a @click="isTuijian=true" href="javascript:;"></a>
    </header>
    <div class="tian">
        <a href="javascript:;" class="wawa"></a>
        <ul class="tian-m">
            <li @click="mai(item)" :class="item.enabled?'active':''" v-for="(item,index) in tian">
                <span></span>
                <i :class="'numji-'+item.chickens.length">
                    <i></i>
                    <em :class="j.no_get_eggs>0?'active':''" @click="put_dan(j,index,index2)" v-for="(j,index2) in item.chickens"></em>
                </i>
            </li>
        </ul>
        <a href="javascript:;" class="gril"></a>
    </div>
    <nav class="menu">
        <a href="javascript:;">
            <i></i>
            <p>蛋 ×{{j_data.dan}}</p>
        </a>
        <a @click="mai2(1)" href="javascript:;">
            <i></i>
            <p>鸡 ×{{j_data.ji}}</p>
        </a>
        <a @click="mai2(2)" href="javascript:;">
            <i></i>
            <p>地 ×{{j_data.di}}</p>
        </a>
        <a @click="show_menu_cz(1)" href="javascript:;">
            <i></i>
            <p>充值</p>
        </a>
        <a @click="show_menu_cz(2)" href="javascript:;">
            <i></i>
            <p>提现</p>
        </a>
    </nav>

    <section class="c-ad">
        <i></i>
    </section>

    <div @click="isMenuCz=0" :class="['menu-cz-mask',isMenuCz>0?'':'hide']"></div>
    <div :class="['menu-cz',isMenuCz>0?'active':'']">
        <a @click="isMenuCz=0" class="menu-close" href="javascript:;"></a>
        <div class="menu-alldan">{{j_data.dan}}</div>
        <div class="menu-z-all"></div>
        <input class="menu-fill" v-model="c_money" type="tel" />

        <nav class="menu-nav">
            <a @click="cz(item)" v-for="(item,index) in 2" :class="isMenuCz==item?'active':''" href="javascript:;"></a>
        </nav>

    </div>

    <div @click="isTuijian=false" :class="['tuijian',isTuijian?'':'hide']">
        <ul class="tuijian-f">
            <li v-for="s_f in recommand_list">
                <img :src="s_f.headimgurl" />
                <p>{{s_f.nickname}}</p>
            </li>
        </ul>
    </div>

    <div @click="isGuize=false" :class="['z-guize-mask',isGuize?'':'hide']"></div>
    <div :class="['z-guize',isGuize?'active':'']">
        <div class="z-guize-con">
            <p>1、充值之后才能开始我们的游戏之旅；</p>
            <p>2、首先你得兑换了蛋（1元兑换1个蛋，买蛋数量无上限），且完成开地（10个蛋兑换1块地，最多10块地，地买后永久使用）</p>
            <p>3、买鸡养鸡（100个蛋兑换1只鸡，1块地最多2只鸡，每只鸡每天生5个蛋，每只鸡最多生150蛋）；</p>
            <p>4、游戏玩家通过每天鸡生蛋收获鸡蛋（1只鸡每天5个蛋），</p>
            <p>5、推荐小伙伴加入游戏系统，奖励直推下线每天的生蛋总量10%收入。</p>
            <p>6、已获得的鸡蛋，按10个蛋的倍数进行提现。</p>
            <p>7、每天提现时间9：00-18：00，五个小时之内到账。</p>
        </div>
        <a @click="isGuize=false" class="a_c z-guize-btn" href="javascript:;"></a>
    </div>


    <div @click="is_tx=false" :class="['s_input-mask',is_tx?'':'hide']"></div>
    <div @click="is_tx=false" :class="['s_input',is_tx?'':'hide']">
        <span class="s_close"></span>
        <input placeholder="请输入提款金额" v-model="t_money" type="tel" />
        <input placeholder="请输入姓名" v-model="tx_name" type="text" />
        <input placeholder="请输入联系方式" v-model="tx_tel" type="tel" />
        <input placeholder="请输入卡号" v-model="tx_card" type="tel" />
        <a @click="tx()" class="a_c" href="javascript:;"></a>
    </div>

    <div :class="['chicken-t',a_message.isClose?'hide':'']">
        <div @click="a_message.isClose=true" class="t-mask"></div>
        <div :class="[a_message.isStatus==1?'t-success':'t-error']">
            <p>{{a_message.message}}</p>
            <a @click="a_message.isClose=true" class="a_c" href="javascript:;"></a>
        </div>
    </div>
   
    <div v-if="iswaiting" class="loading-spinner-mask"></div>
    <div v-if="iswaiting" class="loading-spinner"></div>

</article>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/public/home/js/vue.js"></script>
<script type="text/javascript" src="/public/home/js/ajax.js"></script>


<script type="text/javascript">
    var shareData = {
        title: '金鸡报春，喜迎2017，邀您边游戏边理财。。。', // 分享标题
        desc: '', // 分享描述
        link: "<?php echo $link;?>",// 分享链接
        imgUrl: 'http://www.sqweichao.com/public/home/images/two_ji.png', // 分享图标
        success: function () {},
        cancel: function () {}
    };
    var config = {
        debug: false,
        appId: "wxf691fb1f4059c9f3",
        timestamp: "<?php echo $create_time;?>",
        nonceStr: "bitch",
        signature: "<?php echo $signature;?>",
        jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo']
    };
    wx.config(config);

    wx.ready(function(){
        wx.onMenuShareTimeline(shareData);
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareQQ(shareData);
        wx.onMenuShareWeibo(shareData);
    });

</script>

<script type="text/javascript" src="/public/home/js/chicken.js"></script>

</body>
</html>