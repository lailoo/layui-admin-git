
<?php
require ('./PHP/websiteEntry.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>建筑信息管理系统后台</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" href="layui/css/layui.css" media="all" />
        <link rel="stylesheet" href="../../css/font_eolqem241z66flxr.css" media="all" />
        <link rel="stylesheet" href="css/main.css" media="all" />
    </head>
    <body class="main_body">
        <div class="layui-layout layui-layout-admin">
            <!-- 顶部 -->
            <div class=" layui-header admin-header">
                <div class="layui-main  ">
                    <a href="#" class="logo">后台管理系统</a>
                    <!-- 顶部右侧菜单 -->
                    <ul class="layui-nav top_menu ">
                        <li class="layui-nav-item admin-header-nav-item-li" pc>
                            <a href="../phpmyadmin/" target="_blank"><i class="iconfont icon-gonggao"></i><cite>phpMyAdmin数据库管理工具</cite></a>
                        </li>
<!--                        <li class="layui-nav-item" mobile>
                            <a href="javascript:;" data-url="page/user/changePwd.html"><i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>设置</cite></a>
                        </li>
                        <li class="layui-nav-item" mobile>
                            <a href="javascript:;"><i class="iconfont icon-loginout"></i> 退出</a>
                        </li>-->
                        <li class="layui-nav-item admin-header-nav-item-li" pc>
                            <a id="link_signout"><i class="iconfont icon-loginout"><img src="images/face.jpg" class="layui-circle" width="35" height="35"></i><cite>退出</cite></a>
<!--                            <a href="javascript:;">
                                <img src="images/face.jpg" class="layui-circle" width="35" height="35">
                                <cite></cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd><a id="link_updateuserinfo"><i class=" iconfont icon-zhanghu" data-icon="icon-zhanghu"></i><cite>个人资料</cite></a></dd>
                                <dd><a  id="link_updatepassword"><i class=" iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>修改密码</cite></a></dd>
                                <dd><a id="link_signout"><i class="iconfont icon-loginout"></i><cite>退出</cite></a></dd>
                            </dl>-->
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 左侧导航 -->
            <div class="layui-side layui-bg-black heightOfNavAndBody layui-side-this">
                <div class="user-photo">
                    <a class="img" title="我的头像" ><img src="images/face.jpg"></a>
                    <p>你好！<span class="userName"><?php echo $_COOKIE['user_name'] ?></span>， 欢迎登录</p>
                </div>
                <div class="navBar layui-side-scroll"></div>
            </div>
            <!-- 右侧内容 -->
            <div class="layui-body layui-form heightOfNavAndBody">
                <div class="layui-tab marg0" lay-filter="bodyTab">
                    <ul class="layui-tab-title top_tab">
                        <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>后台首页</cite></li>
                    </ul>
                    <div class="layui-tab-content clildFrame">
                        <div class="layui-tab-item layui-show">
                            <iframe src="page/main.html"></iframe>
                        </div>
                    </div>
                </div>
            </div>
<!--             底部 
            <div class="layui-footer footer">
                <p>copyright @2017 </p>
            </div>-->
        </div>

        <div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
        <div class="site-mobile-shade"></div>

        <script type="text/javascript" src="layui/layui.js"></script>
        <!-- 配置文件 -->
        <script type="text/javascript" src="ueditor1_4_3_3-utf8-php/utf8-php/ueditor.config.js"></script>
        <!-- 编辑器源码文件 -->
        <script type="text/javascript" src="ueditor1_4_3_3-utf8-php/utf8-php/ueditor.all.js"></script>
        
        <script type="text/javascript" src="js/nav.js"></script>
        <script type="text/javascript" src="js/leftNav.js"></script>
        <script type="text/javascript" src="js/index.js"></script>
        <script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.js"></script> 
    </body>
</html>
