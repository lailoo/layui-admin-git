layui.config({
    base: "js/"
}).use(['form', 'layer', 'jquery', 'laypage'], function () {
    var form = layui.form(),
            layer = parent.layer === undefined ? layui.layer : parent.layer,
            laypage = layui.laypage,
            $ = layui.jquery;
    //加载页面数据
    var linksData = '';
    getList();
    var currPage = 1;
    var numPage = 10;

    function getList() {

        var pageData = {curr: 1, num: 10, searchword: $(".search_input").val()};
        $.ajax({
            url: "../../PHP/basicbuilding.php",
            type: "get",
            data: pageData,
            dataType: "html",
            success: function (data) {
                linksData = data;
                //执行加载数据的方法
                linksList();
                var countPages = 10;
                $.ajax({
                    url: "../../PHP/basicbuildingCount.php",
                    type: "get",
                    dataType: "html",
                    success: function (data) {
                        countPages = parseInt(data);
                    }
                })
                laypage({
                    cont: "page",
                    pages: Math.ceil(countPages / numPage),
                    curr: currPage,
                    jump: function (obj) {
                        pageData.curr = obj.curr;
                        pageData.num = numPage;
                        $.ajax({
                            url: "../../PHP/basicbuilding.php",
                            type: "get",
                            data: pageData,
                            dataType: "html",
                            success: function (data) {
                                linksData = data;
                                //执行加载数据的方法
                                linksList();
                            }
                        }
                        );
                        form.render(); 
                    }
                })
            }
        })
    }
    function linksList(that) {
        if (that) {
            linksData = that;
        }
        $(".links_content").html(linksData);
    }



//查询
    $(".search_btn").click(function () {
        var newArray = [];
        if ($(".search_input").val() != '') {
            var index = layer.msg('查询中，请稍候', {icon: 16, time: false, shade: 0.8});
            getList();
            layer.close(index);
        } else {
            layer.msg("请输入需要查询的内容");
            getList();
        }
    })

    //添加友情链接
    $(".linksAdd_btn").click(function () {
        $.ajax({
            url: "../../PHP/basicbuildingAdd.php",
            type: 'get',
            datatype: 'html',
            success: function (data) {
                layer.open({
                    title: "基本建筑信息添加",
                    type: 1,
                    content: data,
                    shade: 0.9,
                    closeBtn: 2,
                    area: ['50%', '80%'],
                    cancel: function (index) {
                        layer.close(index);
                    },
                    success: function (layero, index) {
                        layero.find("#submitadd").click(function () {
                            var adddata = layero.find("#addform").serialize();
                            $.ajax({
                                url: "../../PHP/basicbuildingAddProc.php",
                                type: "post",
                                data: adddata,
                                datatype: "html",
                                success: function (data) {

                                    if (parseInt(data) == 200) {
                                        layer.msg("添加成功！");
                                    } else {
                                        layer.msg("添加失败！");
                                    }
                                    getList();
                                    layer.close(index);
                                }
                            });
                            return false;
                        });
                        layero.find("submitcancel").click(function () {
                            layer.close(index);
                        });
                    }
                })
            }
        })
    })

    //批量删除
    $(".batchDel").click(function () {
        var $checkbox = $('.links_list tbody input[type="checkbox"][name="checked"]');
        var $checked = $('.links_list tbody input[type="checkbox"][name="checked"]:checked');
        if ($checkbox.is(":checked")) {
            layer.confirm('确定删除选中的信息？', {icon: 3, title: '提示信息'}, function (index) {
                var index = layer.msg('删除中，请稍候', {icon: 16, time: false, shade: 0.8});
                setTimeout(function () {
                    //删除数据
                    for (var j = 0; j < $checked.length; j++) {
                        for (var i = 0; i < linksData.length; i++) {
                            if (linksData[i].linksId == $checked.eq(j).parents("tr").find(".links_del").attr("data-id")) {
                                linksData.splice(i, 1);
                                linksList(linksData);
                            }
                        }
                    }
                    $('.links_list thead input[type="checkbox"]').prop("checked", false);
                    form.render();
                    layer.close(index);
                    layer.msg("删除成功");
                }, 2000);
            })
        } else {
            layer.msg("请选择需要删除的文章");
        }
    })
    //全选
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
        child.each(function (index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });
    //通过判断文章是否全部选中来确定全选按钮是否选中
    form.on("checkbox(choose)", function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
        var childChecked = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"]):checked')
        data.elem.checked;
        if (childChecked.length == child.length) {
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = true;
        } else {
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = false;
        }
        form.render('checkbox');
    });



    //操作
    $("body").on("click", ".links_edit", function () {  //编辑
        var _this = $(this);
        var data = {dataid: _this.attr('data-id')};
        $.ajax({
            url: "../../PHP/basicbuildingEdit.php",
            type: 'get',
            data: data,
            datatype: 'html',
            success: function (data) {
                layer.open({
                    title: '编辑页面',
                    type: 1,
                    content: data,
                    closeBtn: 2,
                    shade: 0.9,
                    area: ['50%', '80%'],
                    cancel: function (index, layero) {
                        layer.close(index);
                    },
                    success: function (layero, index) {
                        layero.find("#submitedit").click(function () {
                            var editdata = layero.find("#editform").serialize();
                            $.ajax({
                                url: "../../PHP/basicbuildingEditProc.php",
                                type: "post",
                                data: editdata,
                                datatype: "html",
                                success: function (data) {
                                    if (parseInt(data) == 200) {
                                        layer.msg("修改成功");
                                    }
                                    layer.close(index);
                                    getList();
                                }
                            });
                            return false;
                        });
                        layero.find("#submitcancel").click(function () {
                            layer.close(index);
                        });
                    }
                });
            }
        });

    });
    $("body").on("click", ".links_del", function () {  //删除
        var _this = $(this);
        layer.confirm('确定删除此信息？', {icon: 3, title: '提示信息'}, function (index) {
            //_this.parents("tr").remove();
            data = {dataid: _this.attr('data-id')};

            $.ajax({
                url: "../../PHP/basicbuildingDel.php",
                type: "get",
                data: data,
                dataType: "html",
                success: function (data) {
                    if (parseInt(data) == 200) {
                        //执行加载数据的方法
                        layer.msg('删除成功！');
                        getList();
                    }
                }
            });
            layer.close(index);
        });
    });
});
