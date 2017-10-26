/*
 @Author: 请叫我马哥
 @Time: 2017-04
 @Tittle: tab
 @Description: 点击对应按钮添加新窗口
 */
var tabFilter, liIndex, curNav, delMenu;
var currtaptitle = "";
layui.define(["element", 'laypage', 'form', 'layer', 'jquery', 'table'], function (exports) {
    var element = layui.element,
            layer = parent.layer === undefined ? layui.layer : parent.layer,
            form = layui.form,
            laypage = layui.laypage,
            table = layui.table,
            $ = layui.jquery,
            layId,
            Tab = function () {
                this.tabConfig = {
                    closed: true,
                    openTabNum: 10,
                    tabFilter: "bodyTab"
                }
            };

    //显示左侧菜单
    if ($(".navBar").html() == '') {
        var _this = this;
        $(".navBar").html(navBar(navs)).height($(window).height() - 230);
        element.init();  //初始化页面元素
        $(window).resize(function () {
            $(".navBar").height($(window).height() - 230);
        })
    }

    //参数设置
    Tab.prototype.set = function (option) {
        var _this = this;
        $.extend(true, _this.tabConfig, option);
        return _this;
    };

    //通过title获取lay-id
    Tab.prototype.getLayId = function (title) {
        $(".layui-tab-title.top_tab li").each(function () {
            if ($(this).find("cite").text() == title) {
                layId = $(this).attr("lay-id");
            }
        })
        return layId;
    }
    //通过title判断tab是否存在
    Tab.prototype.hasTab = function (title) {
        var tabIndex = -1;
        $(".layui-tab-title.top_tab li").each(function () {
            if ($(this).find("cite").text() == title) {
                tabIndex = 1;
            }
        })
        return tabIndex;
    }

    //右侧内容tab操作
    var tabIdIndex = 0;
    Tab.prototype.tabAdd = function (_this) {
        var that = this;
        var closed = that.tabConfig.closed,
                openTabNum = that.tabConfig.openTabNum;
        tabFilter = that.tabConfig.tabFilter;
        if (currtaptitle != "" && currtaptitle != "后台首页") {
            element.tabDelete(tabFilter, that.getLayId(currtaptitle));
        }

        if (_this.find("i.iconfont,i.layui-icon").attr("data-icon") != undefined) {
            var title = '';
            if (that.hasTab(_this.find("cite").text()) == -1 && _this.siblings("dl.layui-nav-child").length == 0) {
                if ($(".layui-tab-title.top_tab li").length == openTabNum) {
                    layer.msg('只能同时打开' + openTabNum + '个选项卡哦。不然系统会卡的！');
                    return;
                }
                tabIdIndex++;
                if (_this.find("i.iconfont").attr("data-icon") != undefined) {
                    title += '<i class="iconfont ' + _this.find("i.iconfont").attr("data-icon") + '"></i>';
                } else {
                    title += '<i class="layui-icon">' + _this.find("i.layui-icon").attr("data-icon") + '</i>';
                }
                title += '<cite>' + _this.find("cite").text() + '</cite>';
                //保存当前tap的title
                currtaptitle = _this.find("cite").text();


                title += '<i class="layui-icon layui-unselect layui-tab-close" data-id="' + tabIdIndex + '">&#x1006;</i>';
                if (_this.attr("data-url") != undefined) {
                    var tablePara = {tablename: _this.attr("data-url")};
                    if (tablePara.tablename == "t_dynamicdatashow") {
                        //对标判断页面进行特殊处理
                        var src = './page/mapexample.html';
                        element.tabAdd(tabFilter, {
                            title: title,
                            content: "<iframe src=\" " + src + " \" frameborder=0></iframe>",
                            id: new Date().getTime()
                        });
                        element.tabChange(tabFilter, that.getLayId(_this.find("cite").text())).init();
                    } else {
                        //常规表格页面获取
                        //获取表头信息
                        $.ajax({
                            url: "./PHP/tableTitleFetch.php",
                            type: "get",
                            data: tablePara,
                            dataType: "html",
                            success: function (data) {
                                element.tabAdd(tabFilter, {
                                    title: title,
                                    content: data,
                                    id: new Date().getTime()
                                });

                                element.tabChange(tabFilter, that.getLayId(_this.find("cite").text())).init();
                                that.bindEventForCurrTab();//获取表数据，完成页面的创建


                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {  //#3这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
                                alert(XMLHttpRequest.status);
                                alert(XMLHttpRequest.readyState);
                                alert(errorThrown); // paser error;
                            },
                        });
                    }
                }
            } else {
                element.tabChange(tabFilter, that.getLayId(_this.find("cite").text()));
            }
        }
    }
    var numPage = 5;
    var currpage = 1;
    Tab.prototype.bindEventForCurrTab = function () {
        //加载页面数据
        getList();
        //查询

    }
    function getList() {
        var tableData = {tablename: $("#curr_table").attr("tablename"), colnum: $("#curr_table").attr("colnum"),
            searchword: $(".search_input").val()};
        $.ajax({
            url: "./PHP/tableDataCountFetch.php",
            type: "get",
            data: tableData,
            dataType: "html",
            success: function (data) {

                totalNumOfPages = parseInt(data);
                laypage.render({
                    elem: 'page',
                    count: totalNumOfPages,
                    layout: ['count', 'prev', 'page', 'next', 'limit', 'skip'],
                    jump: function (obj) {
                        tableData.curr = obj.curr;
                        tableData.limit = obj.limit;
                        tableData.searchword = $(".search_input").val();
                        $.ajax({
                            url: "./PHP/tableDataFetch.php",
                            type: "get",
                            data: tableData,
                            dataType: "html",
                            success: function (data) {
                                //执行加载数据的方法
                                linksList(data);
                            }
                        });
                        form.render();
                    }
                })
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {  //#3这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
                alert(XMLHttpRequest.status);
                alert(XMLHttpRequest.readyState);
                alert(textStatus); // paser error;
            },
        });

    }
    function showTable() {
        table.init("curr_table", {
            height: 390
        });
    }
    function linksList(that) {
        $(".links_content").html(that);
        showTable();
    }

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
        var data = {tablename: $("#curr_table").attr("tablename"), dataid: _this.attr('data-id'),
            colnum: $("#curr_table").attr("colnum")};
        $.ajax({
            url: "./PHP/tableDataEdit.php",
            type: 'get',
            data: data,
            datatype: 'html',
            success: function (data) {
                form.render();
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
                        form.render();
                        layero.find("#submitedit").click(function () {
                            var editData = layero.find("#tableEditForm").serialize();
                            editData += "&tablename=" + layero.find("#tableEditForm").attr("tablename");
                            editData += "&colnum=" + layero.find("#tableEditForm").attr("colnum");
                            $.ajax({
                                url: "./PHP/tableDataEditProc.php",
                                type: "get",
                                data: editData,
                                datatype: "html",
                                success: function (data) {
                                    if (parseInt(data) == 200) {
                                        layer.msg("修改成功");
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
    });
    $("body").on('click', '.excelBatchImport', function () {
        var excelFileImportPageContent="./page/excelFileUpload.html"
        var pageTitle = "Excel文件上传";
        layer.open({
            type: 2,
            title: pageTitle,
            area: ["60%", "80%"],
            content: excelFileImportPageContent,
            cancel: function (index) {
                layer.close(index);
                getList();
            }
        });
    });
    $("body").on("click", ".search_btn", function () {
        if ($(".search_input").val() != '') {
            var index = layer.msg('查询中，请稍候', {icon: 16, time: false, shade: 0.8});
            getList();
            layer.close(index);
        } else {
            layer.msg("请输入需要查询的内容");
            getList();
        }
    });

    $("body").on("click", ".links_del", function () {  //删除
        var _this = $(this);
        layer.confirm('确定删除此信息？', {icon: 3, title: '提示信息'}, function (index) {
            data = {tablename: $("#curr_table").attr("tablename"), dataid: _this.attr('data-id')};
            $.ajax({
                url: "./PHP/tableDataDel.php",
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

    //添加友情链接
    var ue;
    $("body").on("click", ".linksAdd_btn", function () {

        var tableData = {tablename: $("#curr_table").attr("tablename"), colnum: $("#curr_table").attr("colnum"),
            curr: currpage, num: numPage, searchword: $(".search_input").val()};
        //添加文章，弹出窗口显示一个编辑页面
        if (tableData.tablename == "t_articleinfo") {
            var thisTab = new Tab();

            //
            var articleAddPageContent = "<form action='' id='articleAddForm' class='layui-form' >"
            articleAddPageContent += "<div class=\"layui-form-item\" style=\"width:500px\">" +
                    "<label class=\"layui-form-label\" >文章标题：</label>" +
                    "<div class=\"layui-input-block\">" +
                    "<input type='text' class='layui-input' id='articleTitle' name='articleTitle' placeholder='请在这里输入你的文档标题'  lay-verify='required'>" +
                    "</div>" +
                    "</div>";

            articleAddPageContent += "<script id='container' name='content' type='text/plain'>请编辑新的文档</script>";
            articleAddPageContent += " <div class='layui-form-item' style='margin:10px;'>" +
                    "<div class=\"layui-input-block\">" +
                    "<button type=\"button\" class=\"layui-btn layui-btn-normal dp-block\"  id=\"articleAddSubmit\">文档提交</button>" +
                    "<button class=\"layui-btn\" id=\"articleContentClear\">清空文档</button>"
                    + "</div>"
                    + "</div>";
            articleAddPageContent += "</form>";
            //


            var articleTitle = "文章添加";
            tabFilter = thisTab.tabConfig.tabFilter;
            //删除当前tab
            if (currtaptitle != "" && currtaptitle != "后台首页") {
                element.tabDelete(tabFilter, thisTab.getLayId(currtaptitle));
            }

            //
            var title = "";
            tabIdIndex++;
            title += '<i class="layui-icon"> &#xe631</i>';
            title += '<cite>' + articleTitle + '</cite>';
            //保存当前tap的title
            currtaptitle = articleTitle;
            title += '<i class="layui-icon layui-unselect layui-tab-close" data-id="' + tabIdIndex + '">&#x1006;</i>';

            //
            element.tabAdd(tabFilter, {
                title: title,
                content: articleAddPageContent,
                id: new Date().getTime()
            });
            //利用全局变量来实现tab标签页面切换时的ueditor不能重新加载的问题
            if (typeof (ue) != "undefined") {
                ue.destroy();
            }


            //
            var initialFrameHeight = 300;
            ue = UE.getEditor("container", {
                initialFrameHeight: initialFrameHeight,
                autoHeightEnabled: false
//                toolbars: [['fullscreen', 'source', 'undo', 'redo', 'indent', 'bold', 'italic', 'underline', 'fontborder', 'snapscreen', 'print', 'preview', 'link', 'unlink', 'insertrow', 'insertcol', 'mergeright', 'mergedown', 'deleterow', 'deletecol', 'splittorows', 'splittocols', 'splittocells', 'fontfamily', 'fontsize', 'simpleupload', 'insertimage', 'spechars', 'searchreplace', 'justifyleft', 'justifyright', 'justifycenter'],
//                    ['justifyjustify', 'forecolor', 'backcolor', 'attachment', 'imagecenter', 'wordimage', 'inserttable', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']],
            });
            //
            element.tabChange(tabFilter, thisTab.getLayId(articleTitle)).init();
        } else {
            $.ajax({
                url: "./PHP/tableDataAdd.php",
                type: 'get',
                data: tableData,
                datatype: 'html',
                success: function (data) {
                    layer.open({
                        title: "数据添加",
                        type: 1,
                        content: data,
                        shade: 0.9,
                        closeBtn: 2,
                        area: ['50%', '80%'],
                        cancel: function (index) {
                            layer.close(index);
                        },
                        success: function (layero, index) {
                            form.render();
                            layero.on("click", "#submitadd", function () {

                                var addData = layero.find("#tableDataAddForm").serialize();

                                addData += "&tablename=" + layero.find("#tableDataAddForm").attr("tablename");
                                addData += "&colnum=" + layero.find("#tableDataAddForm").attr("colnum");

                                $.ajax({
                                    url: "./PHP/tableDataAddProc.php",
                                    type: "get",
                                    data: addData,
                                    datatype: "html",
                                    success: function (data) {

                                        if (parseInt(data) == 200) {
                                            layer.msg("添加成功！");
                                        }
                                        getList();
                                        layer.close(index);
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {  //#3这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
                                        alert(XMLHttpRequest.status);
                                        alert(XMLHttpRequest.readyState);
                                        alert(errorThrown); // paser error;
                                    }
                                });
                                return false;
                            });
                            layero.on("click", "#submitcancel", function () {
                                layer.close(index);
                            });
                            form.render();
                        }
                    })
                }
            });
        }

    });
    $('body').on("click", '#articleAddSubmit', function () {
        if (!ue.hasContents()) {
            layer.msg("文章内容不能为空,请编辑文章内容！");
            return false;
        }
        if ($.trim($("#articleTitle").val()) == "") {
            layer.msg("文章标题不能为空,请编辑文章标题！");
            return false;
        }

//        layer.msg( ue.getAllHtml());
//        layer.msg(ue.getContent());
        var articleContent = $('#articleAddForm').serialize();
        if (!ue.hasContents()) {
            layer.msg("文章内容不能为空,请编辑文章内容！");
            return false;
        }
        articleContent += "&allhtml=" + ue.getAllHtml();
//        articleContent += "&articlecContent=" + ue.getContent();
//        alert(articleContent);
        $.ajax({
            url: "./PHP/articleAddProc.php",
            type: "post",
            datatype: "html",
            data: articleContent,
            success: function (data) {
//                alert(data);
//                layer.msg(data);
                if (parseInt(data) == 200) {
                    layer.msg("文章插入成功!请继续编辑新文章。");
                } else {
                    layer.msg("文章提交失败，错误信息如下：" + data, {
                        icon: 5
                    });
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {  //#3这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
                alert(XMLHttpRequest.status);
                alert(XMLHttpRequest.readyState);
                alert(errorThrown); // paser error;
            }
        });

    });
    $('body').on("click", '#articleContentClear', function () {
        ue.execCommand('cleardoc');
        return false;
    });
    //批量删除
    $("body").on("click", ".batchDel", function () {
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
    });

    $("body").on("click", ".top_tab li", function () {
        element.tabChange(tabFilter, $(this).attr("lay-id")).init();
    });
    //删除tab
    $("body").on("click", ".top_tab li i.layui-tab-close", function () {
        element.tabDelete("bodyTab", $(this).parent("li").attr("lay-id")).init();
    });
    var bodyTab = new Tab();
    exports("bodyTab", function (option) {
        return bodyTab.set(option);
    });
})