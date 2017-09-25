<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("websiteEntry.php");
$tableName = $_GET['tablename'];
$colNum = intval($_GET['colnum']);
$pageRowNum = intval($_GET['num']);
$currPage = (intval($_GET['curr'])-1)*$pageRowNum;
$searchWord = trim($_GET['searchword']);

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query("SET NAMES utf8");
 

$query = "SELECT * FROM  $tableName where field_1 like '%$searchWord%' limit $currPage,$pageRowNum";
$result = mysqli_query($dbc, $query);
$num=mysqli_num_rows($result);
$dataHtml = "";

while ($row = mysqli_fetch_array($result)) {
    $dataHtml .= '<tr>'
            . '<td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>'
            . '<td align="left">' . $row['id'] . '</td>';
    $realColNum = $colNum == 0 ? TOTALFIELDNUMS : $colNum;
    for ($i = 1; $i <= $realColNum; $i++) {
        $dataHtml.= '<td>' . $row["field_$i"] . '</td>';
    }
    $dataHtml.= '<td>'
            . '<a class="layui-btn layui-btn-mini links_edit" data-id="' . $row['id'] . '" ><i class="layui-icon">&#xe642;</i> 编辑</a><br/>'
            . '<a class="layui-btn layui-btn-danger layui-btn-mini links_del" data-id="' . $row['id'] . '"><i class="layui-icon">&#xe640;</i> 删除</a>'
            . '</td>'
            . '</tr>';
}
echo $dataHtml;
mysqli_close($dbc);
