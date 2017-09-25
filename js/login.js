layui.config({
    base: '../js/modules/'
}).use(['jquery', 'form', 'layer'], function () {
    var form = layui.form,
            layer = layui.layer,
            swiper = layui.swiper,
            $ = layui.jquery;

    var lrpObjs = {
        $imgHolder: $('#switch-bg-list'),
        $target: $('#bg-overlay'),
        lrg_a: $('.login,.reg,.forgetPass'),
        logForm_input: $("#loginForm input"),
        log_reg_pass: $("#loginForm,#regForm,#updatePassForm")
    }

    $(document).ready(function () {
        var $bgBtn = lrpObjs.$imgHolder.find('.switch-chg-bg');
        $bgBtn.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var $el = $(this);
            if ($el.hasClass('active') || lrpObjs.$imgHolder.hasClass('disabled'))
                return;
            if ($el.hasClass('bg-trans')) {
                lrpObjs.$target.css('background-image', 'none').removeClass('bg-img');
                lrpObjs.$imgHolder.removeClass('disabled');
                $bgBtn.removeClass('active');
                $el.addClass('active');

                return;
            }

            lrpObjs.$imgHolder.addClass('disabled');
            var url = $el.attr('src').replace('/thumbs', '');

            $('<img/>').attr('src', url).load(function () {
                lrpObjs.$target.css('background-image', 'url("' + url + '")').addClass('bg-img');
                lrpObjs.$imgHolder.removeClass('disabled');
                $bgBtn.removeClass('active');
                $el.addClass('active');

                $(this).remove();
            })

        });

    });

    /**
     *  canves 背景 动画
     */
    canvas_am();
    function canvas_am() {
        var canvas = document.querySelector("canvas"),
                ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        ctx.lineWidth = 0.3;
        ctx.strokeStyle = (new Color(150)).style;
        var mousePosition = {
            x: 30 * canvas.width / 100,
            y: 30 * canvas.height / 100
        };
        var dots = {
            nb: 150,
            distance: 50,
            d_radius: 100,
            array: []
        };

        function colorValue(min) {
            return Math.floor(Math.random() * 255 + min)
        }

        function createColorStyle(r, g, b) {
            return "rgba(" + r + "," + g + "," + b + ", 0.8)"
        }

        function mixComponents(comp1, weight1, comp2, weight2) {
            return(comp1 * weight1 + comp2 * weight2) / (weight1 + weight2)
        }

        function averageColorStyles(dot1, dot2) {
            var color1 = dot1.color,
                    color2 = dot2.color;
            var r = mixComponents(color1.r, dot1.radius, color2.r, dot2.radius),
                    g = mixComponents(color1.g, dot1.radius, color2.g, dot2.radius),
                    b = mixComponents(color1.b, dot1.radius, color2.b, dot2.radius);
            return createColorStyle(Math.floor(r), Math.floor(g), Math.floor(b))
        }

        function Color(min) {
            min = min || 0;
            this.r = colorValue(min);
            this.g = colorValue(min);
            this.b = colorValue(min);
            this.style = createColorStyle(this.r, this.g, this.b)
        }

        function Dot() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.vx = -0.5 + Math.random();
            this.vy = -0.5 + Math.random();
            this.radius = Math.random() * 2;
            this.color = new Color();
            console.log(this)
        }
        Dot.prototype = {
            draw: function () {
                ctx.beginPath();
                ctx.fillStyle = this.color.style;
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
                ctx.fill()
            }
        };

        function createDots() {
            for (i = 0; i < dots.nb; i++) {
                dots.array.push(new Dot())
            }
        }

        function moveDots() {
            for (i = 0; i < dots.nb; i++) {
                var dot = dots.array[i];
                if (dot.y < 0 || dot.y > canvas.height) {
                    dot.vx = dot.vx;
                    dot.vy = -dot.vy
                } else {
                    if (dot.x < 0 || dot.x > canvas.width) {
                        dot.vx = -dot.vx;
                        dot.vy = dot.vy
                    }
                }
                dot.x += dot.vx;
                dot.y += dot.vy
            }
        }

        function connectDots() {
            for (i = 0; i < dots.nb; i++) {
                for (j = 0; j < dots.nb; j++) {
                    i_dot = dots.array[i];
                    j_dot = dots.array[j];
                    if ((i_dot.x - j_dot.x) < dots.distance && (i_dot.y - j_dot.y) < dots.distance && (i_dot.x - j_dot.x) > -dots.distance && (i_dot.y - j_dot.y) > -dots.distance) {
                        if ((i_dot.x - mousePosition.x) < dots.d_radius && (i_dot.y - mousePosition.y) < dots.d_radius && (i_dot.x - mousePosition.x) > -dots.d_radius && (i_dot.y - mousePosition.y) > -dots.d_radius) {
                            ctx.beginPath();
                            ctx.strokeStyle = averageColorStyles(i_dot, j_dot);
                            ctx.moveTo(i_dot.x, i_dot.y);
                            ctx.lineTo(j_dot.x, j_dot.y);
                            ctx.stroke();
                            ctx.closePath()
                        }
                    }
                }
            }
        }

        function drawDots() {
            for (i = 0; i < dots.nb; i++) {
                var dot = dots.array[i];
                dot.draw()
            }
        }

        function animateDots() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            moveDots();
            connectDots();
            drawDots();
            requestAnimationFrame(animateDots)
        }
        $("canvas").on("mousemove", function (e) {
            mousePosition.x = e.pageX;
            mousePosition.y = e.pageY
        });
        $("canvas").on("mouseleave", function (e) {
            mousePosition.x = canvas.width / 2;
            mousePosition.y = canvas.height / 2
        });
        createDots();
        requestAnimationFrame(animateDots)
    }

    /**
     * 翻转效果
     */

    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        effect: 'flip',
        noSwiping: true,
        paginationClickable: true,
    });

    lrpObjs.lrg_a.on('click', function () {
        var _className = $(this).context.className;
        lrpObjs.log_reg_pass.find("input").each(function () {
            $(this).val("");
        })
        if (_className === 'reg') {
            $('.swiper-pagination span').eq(1).trigger('click');
        } else if (_className === 'login') {
            $('.swiper-pagination span').eq(0).trigger('click');
        } else if (_className === 'forgetPass') {
            $('.swiper-pagination span').eq(2).trigger('click');
        }
        $(".error-msg").html("");
    });

    /**
     * 登陆 form 表单
     */
    lrpObjs.logForm_input.on('input', function () {
        var _form = $(this).parents('.layui-form'),
                _inputs = _form.find("input");
        if (_inputs.eq(0).val() && _inputs.eq(1).val()) {
            _form.children('button').removeClass("layui-btn-disabled");
            _form.children('button').prop('disabled', false);
        }

    });
//        #loginForm,#regForm,#updatePassForm
//        $("#loginSubmit").on("click",function(){
////               var loginInData=$("#loginForm").serialize();
////               $.ajax({
////                   url:"./login.php",
////                   type:"post",
////                   data:loginInData,
////                   datatype:"html",
////                   success:function(data){
////                       if()
////                   }
////               });
//        })
    $("body").on("click", "#loginSubmit", function () {
        var formdata = $("#loginForm").serialize();
        formdata += "&loginSubmit=";
        $.ajax({
            url: "./login.php",
            type: "post",
            data: formdata,
            datatype: "html",
            success: function (data) {
                if (parseInt(data) == 200) {
                    window.location.href = "../index.php";
                } else {
                    $("#loginForm .error-msg").html("账户不存在或密码错误,请重新输入!");
                }
            }
        });
        return false;
    });
    $("body").on("click", "#regSubmit", function () {
        var formdata = $("#regForm").serialize();
        formdata += "&regSubmit=";
        if ($("#confirm_password").val() != $("#password").val()) {
            $("#regForm .error-msg").html("两次密码输入不一致，请重新输入");
        } else {
            $.ajax({
                url: "./login.php",
                type: "post",
                data: formdata,
                datatype: "html",
                success: function (data) {
                    if (parseInt(data) == 200) {
                        window.location.href = "../index.php";
                    } else {
                        $("#regForm .error-msg").html("注册失败，用户名已存在，请重新输入用户名！");
                    }
                }
            });
        }
        return false;
    });
//	form.on("submit(loginForm)", function(data) {
//                data.field.loginSubmit="";
//                $.ajax({
//                   url:"./login.php",
//                   type:"post",
//                   data:data.field,
//                   datatype:"html",
//                   success:function(data){
//                       alert(data);
//                       if(parseInt(data)==200){
//                           window.location.href = "../index.php";
//                       }else{
//                           $("#loginForm .error-msg").html("账户不存在或密码错误,请重新输入!");
//                       }
//                   }
//                });
//		return false;
//	});

    /**
     * 登陆 form 表单
     */
//	form.on("submit(regForm)", function(data) {
//                data.field.regSubmit="";
//                layer.alert(JSON.stringify(data.field));
//                if(data.field.confirm_password!=data.field.password){
//                    $("#regForm .error-msg").html("两次密码输入不一致，请重新输入");
//                }else{
//                    $.ajax({
//                       url:"./login.php",
//                       type:"post",
//                       data:data.field,
//                       datatype:"html",
//                       success:function(data){
//                           layer.alert(data);
//                           if(parseInt(data)==200){
//                               window.location.href = "../index.php";
//                           }else{
//                                $("#regForm .error-msg").html("注册失败，用户名已存在，请重新输入用户名！");
//                           }
//                       }
//                    });
//                }
////                
////		layer.alert(JSON.stringify(data.field));
//                
//		return false;
//	});
//
//	/**
//	 * 登陆 form 表单
//	 */
//	form.on("submit(updatePassForm)", function(data) {
//            data.field.updateSubmit="";
//		layer.msg(JSON.stringify(data.field));
//		return false;
//	});
});