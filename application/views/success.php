
<div class="system-message">
    <span class="suc"></span>
    <span class="success"
          style="font-size: 24px;"></span>
    <p class="detail"></p>
    <p class="jump">
         <a id="href" href="">跳转</a> 等待时间：2 <b id="wait"></b>
    </p>
</div>
<!--home/common/show-->
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 1) {
                location.href = "http://www.sqweichao.com/onechicken/index.php/admin/tixian/";
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>

<style type="text/css">
    .system-message{ /*padding: 24px 48px; */width:1190px;margin:auto;text-align:center;height: 500px;background: url() right 80px no-repeat; }
    .system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
    .system-message .jump{ padding-top: 10px;margin-right: 60px;}
    .system-message .jump a{ color: #333;}
    .system-message .success,.system-message .error{margin-top:140px;margin-right:65px;height:47px; line-height: 47px; font-size: 26px;display:inline-block; vertical-align:middle;}
    .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
    .suc{margin-top:140px;margin-right:4px;width:37px;height:37px;display:inline-block; vertical-align:middle;background:url(http://www.7gz.com/Public/Js/asyncbox/skins/default/default_bg.gif) no-repeat -106px 0}
    .err{margin-top:145px;width:37px;height:37px;display:inline-block; vertical-align:middle;background:url(http://www.7gz.com/Public/Js/asyncbox/skins/default/default_bg.gif) no-repeat -180px 0}
    .ab_border{opacity:0.9;filter:alpha(opacity=90);font-size:0}


</style>