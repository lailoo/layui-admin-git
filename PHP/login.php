<?php
require("connectvars.php");

$error_msg = "";
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query("SET NAMES utf8");
$query = "";
$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;  
if (!isset($_COOKIE['user_id'])) {
    if (isset($_POST['loginSubmit'])) {
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
        $query = "select id from " . USERTABLE . " where field_1='$username' and field_2=SHA('$password')";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 1) {
            echo "200";
            $row = mysqli_fetch_array($result);
            setcookie('user_id', $row['id'],0,HOMEDIR, $domain, false);  
            setcookie("user_name", $username,0,HOMEDIR,$domain,false);
        } else {
            echo "400";
        }
        exit;
    } elseif (isset($_POST['regSubmit'])) {
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
        $realname = mysqli_real_escape_string($dbc, trim($_POST['realname']));
        $workplace = mysqli_real_escape_string($dbc, trim($_POST['workplace']));
        $userrole = mysqli_real_escape_string($dbc, trim($_POST['userrole']));
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        $otherinfo = mysqli_real_escape_string($dbc, trim($_POST['otherinfo']));
        $query = "select id from " . USERTABLE . " where field_1 = '$username'";
        $result = mysqli_query($dbc, $query);
        if (mysqli_num_rows($result) == 1) {
            echo "400";
            exit;
        }
        $query = "insert into " . USERTABLE . "(field_1,field_2,field_3,field_4,field_5,field_6,field_7)"
                . " values('$username',SHA('$password'),'$realname','$workplace','$userrole','$email','$otherinfo')";
        $result = mysqli_query($dbc, $query);
        $query = "select id from " . USERTABLE . " where field_1 = '$username'";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        setcookie('user_id', $row['id'],0,HOMEDIR, $domain, false);  
        setcookie("user_name", $username,0,HOMEDIR,$domain,false);
        echo "200";
        exit;
    } elseif (isset($_POST['updateSubmit'])) {
        
    } else {
        
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Access-Control-Allow-Origin" content="*">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <title>后台管理系统登录-注册-忘记密码</title>
        <link href="//cdn.bootcss.com/Swiper/3.4.1/css/swiper.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../layui/css/layui.css" />
        <link rel="stylesheet" href="//at.alicdn.com/t/font_405150_y9pymml2wi3yds4i.css" />
        <link rel="stylesheet" href="../css/style.css" />
    </head>

    <body>
        <div class="layui-layout layui-layout-admin">
            <div class="container con-bj">
                <canvas id="canv"></canvas>
                <div id="bg-overlay"></div>
                <div class="cls-content">
                    <div class="cls-content-sm panel">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide swiper-no-swiping">
                                    <div class="panel-body">
                                        <div class="mar-ver">
                                            <img src="../images/face.jpg" />
                                            <h3>后台管理系统</h3>
                                        </div>

                                        <form class="layui-form" action="" id="loginForm">
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="iconfont icon-zhanghu"></i>
                                                    <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input" lay-verify="required">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="iconfont icon-xiugaimima"></i>
                                                    <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input" lay-verify="required">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="error-msg">
                                                </div>
                                            </div>
                                            <!--  lay-submit lay-filter="loginForm"  -->
                                            <button type="button" class="layui-btn layui-btn-normal layui-btn-disabled dp-block" id="loginSubmit" name="loginSubmit" disabled="disabled">登 录</button>
                                        </form>
                                    </div>
                                    <div class="pad-all">
                                        <div class="col-6 box-left">
                                            没有账号？
                                            <a target="_blank" class="reg">立即注册</a>
                                        </div>
                                        <div class="col-6 box-right">
                                            <a target="_blank" class="forgetPass">忘记密码？</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="swiper-slide swiper-no-swiping">
                                    <div class="panel-body">
                                        <div class="mar-ver">
                                            <h3>后台管理系统（注册）</h3>
                                        </div>
                                        <form class="layui-form" action="" id="regForm">
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="iconfont icon-zhanghu"></i>
                                                    <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input" lay-verify="required">
                                                </div>
                                            </div>

                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="iconfont icon-mima"></i>
                                                    <input type="password" name="password" id="password" placeholder="请输入密码" autocomplete="off" class="layui-input" lay-verify="required">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="iconfont icon-querenmima"></i>
                                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="请输入确认密码" autocomplete="off" class="layui-input" lay-verify="required">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="layui-icon">&#xe612;</i>
                                                    <input type="text" name="realname" placeholder="请输入真实姓名" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="layui-icon">&#xe715;</i>
                                                    <input type="text" name="workplace" placeholder="请输入工作单位" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="layui-icon">&#xe613;</i>
                                                    <input type="text" name="userrole" placeholder="请输入角色" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="layui-icon">&#xe64c;</i>
                                                    <input type="text" name="email" placeholder="请输入邮箱" autocomplete="off" class="layui-input" lay-verify="required|email" >
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="layui-icon">&#xe60e;</i>
                                                    <input type="text" name="otherinfo" placeholder="备注" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>

                                            <div class="layui-form-item ipt-text">
                                                <div class="error-msg">
                                                </div>
                                            </div>
                                            <button type="button" class="layui-btn layui-btn-normal dp-block"  id="regSubmit" name ="regSubmit" >注 册</button>
                                        </form>
                                    </div>
                                    <div class="pad-all">
                                        <div class="col-6 box-left">
                                            已有账号？
                                            <a target="_blank" class="login">立即登录</a>
                                        </div>
                                        <div class="col-6 box-right">
                                            注册即表示同意遵守
                                            <a target="_blank">协议条款</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="swiper-slide swiper-no-swiping">
                                    <div class="panel-body">
                                        <div class="mar-ver">
                                            <h3>后台管理系统（忘记密码）</h3>
                                        </div>
                                        <form class="layui-form" action="" id="updatePassForm">
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="iconfont icon-shoujihaoma"></i>
                                                    <input type="text" name="phone" placeholder="请输入手机号码" autocomplete="off" class="layui-input" lay-verify="required">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text code">
                                                <div class="dp-block">
                                                    <i class="iconfont icon-ad80"></i>
                                                    <input type="password" name="code" placeholder="请输入验证码" autocomplete="off" class="layui-input" lay-verify="required">
                                                    <button class="layui-btn layui-btn-small layui-btn-normal">发送验证码</button>
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="dp-block">
                                                    <i class="iconfont icon-mima"></i>
                                                    <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input" lay-verify="required">
                                                </div>
                                            </div>
                                            <div class="layui-form-item ipt-text">
                                                <div class="error-msg">
                                                </div>
                                            </div>
                                            <button type="button" class="layui-btn layui-btn-normal dp-block" id="updateSubmit" name="regSubmit"  >修 改</button>
                                        </form>
                                    </div>
                                    <div class="pad-all">
                                        <div class="col-6 box-left">
                                            <a target="_blank" class="login">立即登录</a>
                                        </div>
                                        <div class="col-6 box-right">
                                            没有账号？
                                            <a target="_blank" class="reg">立即注册</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="switch-bg">
            <div id="switch-bg-list">
                <div class="switch-loading" style="display: none;"></div>
                <img src="../images/bg_img/thumbs/bg-trns.jpg" alt="" class="switch-chg-bg bg-trans active">
                <img src="../images/bg_img/bg-img-1.jpg" alt="" class="switch-chg-bg " />
                <img src="../images/bg_img/bg-img-2.jpg" alt="" class="switch-chg-bg " />
                <img src="../images/bg_img/bg-img-3.jpg" alt="" class="switch-chg-bg " />
                <img src="../images/bg_img/bg-img-4.jpg" alt="" class="switch-chg-bg " />
                <img src="../images/bg_img/bg-img-5.jpg" alt="" class="switch-chg-bg " />
                <img src="../images/bg_img/bg-img-6.jpg" alt="" class="switch-chg-bg " />
                <img src="../images/bg_img/bg-img-7.jpg" alt="" class="switch-chg-bg " />
            </div>
        </div>
        <script src="//cdn.bootcss.com/Swiper/3.4.1/js/swiper.min.js"></script>
        <script type="text/javascript" src="../layui/layui.js"></script>
        <script src="../js/login.js"></script>
    </body>
</html>
<?php
}
else{
    
    $index_url="../index.php";
    header("Location:".$index_url);
//    var_dump($_COOKIE['user_name']);
}
?>
