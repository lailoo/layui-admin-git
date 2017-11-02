var navs = [{
        "title": "后台首页",
        "icon": "icon-computer",
        "href": "page/main.html",
        "spread": false
    }, {
        "title": "基本信息管理",
        "icon": "&#xe61c;",
        "href": "t_buildinginfo", //href指向该页面所展示与操作的表的名称
        "spread": false
    }, {
        "title": "扩展信息管理",
        "icon": "&#xe61c;",
        "href": "t_extendbuildinginfo",
        "spread": false
    }, {
        "title": "测试数据管理",
        "icon": "&#xe61c;",
        "href": "t_testdatainfo",
        "spread": false
    }, {
        "title": "问卷管理",
        "icon": "&#xe61c;",
        "href": "questionnaire",
        "spread": false
    }, {
        "title": "文章管理",
        "icon": "&#xe61c;",
        "href": "",
        "spread": false,
        "children": [
            {
                "title": "推荐文章",
                "icon": "&#xe631;",
                "href": "page/404.html",
                "spread": false
            },
            {
                "title": "文章管理",
                "icon": "&#xe631;",
                "href": "t_articleinfo",
                "spread": false
            }
        ]
    }, {
        "title": "对标判断",
        "icon": "&#xe61c;",
        "href": "",
        "spread": false,
        "children": [
            {
                "title": "动态数据显示",
                "icon": "&#xe631;",
                "href": "t_dynamicdatashow",
                "spread": false
            }
        ]
    }, {
        "title": "用户管理",
        "icon": "&#xe61c;",
        "href": "t_userinfo",
        "spread": false,
    }, {
        "title": "数据库管理",
        "icon": "&#xe61c;",
        "href": "t_systeminfo",
        "spread": false,
    },
    {
        "title": "系统帮助",
        "icon": "&#xe61c;",
        "href": "",
        "spread": false,
    }
];
$.ajax({
    url: "./PHP/menuItemFetch.php",
    type: "get",
    dataType: "json",
    success: function (data) {
        navs = data;
//        alert(data.length);

    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {  //#3这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
        alert(XMLHttpRequest.status);
        alert(XMLHttpRequest.readyState);
        alert(textStatus); // paser error;
    }
});














