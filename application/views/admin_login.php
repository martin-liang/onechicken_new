<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="社区惠">
    <link rel="icon" href="">

    <title>DashBoard平台登陆</title>

    <!-- Bootstrap core CSS -->
    <link href="http://www.sqweichao.com/public/public/Css/admin/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://www.sqweichao.com/public/public/Css/admin/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <script type="text/javascript" src="http://www.sqweichao.com/public/public/Js/jquery.min.js"></script>
    <!--[if lt IE 9]><script src="http://www.sqweichao.com/public/public/Js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://www.sqweichao.com/public/public/Js/ie-emulation-modes-warning.js"></script>
    <script src="http://www.sqweichao.com/public/public/Js/verify.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://www.sqweichao.com/public/public/Js/html5shiv.js"></script>
    <script src="http://www.sqweichao.com/public/public/Js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <form class="form-signin" role="form" id="LoginForm" name="LoginForm" method="post" action="http://www.sqweichao.com/index.php/admin/index"  onsubmit="return check_login(this)" >
        <h2 class="form-signin-heading">平台登录</h2>
        <div class="form-group">
            <input type="text" class="form-control" name="email" value="" required autofocus placeholder="请输入用户名">
        </div>
        <div class=" form-group">
            <input class="form-control" name="password" type="password" placeholder="密码" required>
        </div>
<!--        <div class="row form-group">-->
<!--            <div class="col-lg-6">-->
<!--                <input type="text" class="form-control" name="yzstr" placeholder="验证码" required >-->
<!--            </div>-->
<!--            <div class="col-lg-6">-->
<!--                <img style='cursor:pointer' title='刷新验证码' src='/dashboard/index/verify/' id='verifyImg' onClick="freshVerify('/dashboard/index/verify.html')"/>-->
<!--            </div>-->
<!--        </div>-->
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
    </form>
</div> <!-- /container -->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="http://www.sqweichao.com/public/public/Js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>