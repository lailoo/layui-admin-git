var $, tab, skyconsWeather;
layui.config({
    base: "js/"
}).use(['bodyTab', 'form', 'element', 'layer', 'jquery', 'layedit'], function () {
    var form = layui.form,
            layer = layui.layer;


    $ = layui.jquery;
    tab = layui.bodyTab();

    $(document).on('keydown', function () {
        if (event.keyCode == 13) {
            $("#unlock").click();
        }
    });

    //手机设备的简单适配
    var treeMobile = $('.site-tree-mobile'),
            shadeMobile = $('.site-mobile-shade')

    treeMobile.on('click', function () {
        $('body').addClass('site-mobile');
    });

    shadeMobile.on('click', function () {
        $('body').removeClass('site-mobile');
    });

    // 添加新窗口
    $(".layui-nav .layui-nav-item a ").on("click", function () {
        //用户信息的分支
        if ($(this)[0] == $("#link_updateuserinfo")[0]) {

        } else if ($(this)[0] == $("#link_updatepassword")[0]) {

            $.ajax({
                url: "./PHP/userInfoFetch.php",
                type: 'get',
                datatype: 'html',
                success: function (data) {
                    form.render();
                    layer.open({
                        title: '个人资料',
                        type: 1,
                        content: data,
                        closeBtn: 2,
                        shade: 0.9,
                        area: ['50%', '80%'],
                        cancel: function (index, layero) {
                            layer.close(index);
                        },
                        success: function (layero, index) {
                            form.render();
                            layero.find("#submitedit").click(function () {
                                var editData = layero.find("#tableEditForm").serialize();
                                editData += "&submitedit=";
                                $.ajax({
                                    url: "./PHP/userInfoFetch.php",
                                    type: "get",
                                    data: editData,
                                    datatype: "html",
                                    success: function (data) {
                                        if (parseInt(data) == 200) {
                                            layer.msg("个人资料修改成功");
                                            layer.close(index);
                                            getList();
                                        }
                                    }
                                });
                                return false;
                            });
                            layero.find("#submitcancel").click(function () {
                                layer.close(index);
                            });
                            form.render();
                        }
                    });
                }
            });
        } else if ($(this)[0] == $("#link_signout")[0]) {
            $.ajax({
                url: "./PHP/logout.php",
                type: "post",
                datatype: "html",
                success: function (data) {
                    if (parseInt(data) == 200) {
                        window.location.href = "./index.php";
                    }
                }
            });
        } else if ($(this).attr('data-url') == "questionnaire") {
            
            var appkey='wjrk1gycdidtoip31u';
            var appsecret='06caaf5b6d9f8688081399e89b740274';
            var timestamp=Date.parse(new Date())/1000;
           
            var user='dsbliu';
            
            var signature=md5(appkey+timestamp+user+appsecret);
            var questionaire_href="https://www.wenjuan.com/openapi/v3/login/?"+
                "wj_appkey="+appkey+"&wj_user="+user+"&wj_timestamp="+timestamp+"&wj_signature="+signature;
            window.location.href=questionaire_href;
            
        } else {
            addTab($(this));
            $(this).parent("li").siblings().removeClass("layui-nav-itemed");
        }
    });
})
//打开新窗口
function addTab(_this) {
    tab.tabAdd(_this);

}