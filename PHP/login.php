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
                                                                                    <img src="../images/tx.jpg" />
											<h3>后台管理系统</h3>
										</div>
										<form class="layui-form" action="" id="loginForm">
											<div class="layui-form-item ipt-text">
												<div class="dp-block">
													<i class="iconfont icon-zhanghu"></i>
													<input type="text" name="phone" placeholder="请输入用户名" autocomplete="off" class="layui-input" lay-verify="required">
												</div>
											</div>
											<div class="layui-form-item ipt-text">
												<div class="dp-block">
													<i class="iconfont icon-xiugaimima"></i>
													<input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input" lay-verify="required">
												</div>
											</div>
											<button type="button" class="layui-btn layui-btn-normal layui-btn-disabled dp-block" lay-submit lay-filter="loginForm" id="loginSubmit" disabled="disabled">登 录</button>
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
												<div class="dp-block">
													<i class="iconfont icon-querenmima"></i>
													<input type="password" name="confirm_password" placeholder="请输入确认密码" autocomplete="off" class="layui-input" lay-verify="required">
												</div>
											</div>
											<button type="button" class="layui-btn layui-btn-normal dp-block" lay-submit id="regSubmit" lay-filter="regForm">注 册</button>
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
											<button type="button" class="layui-btn layui-btn-normal dp-block" lay-submit  id="updateSubmit" lay-filter="updatePassForm">修 改</button>
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