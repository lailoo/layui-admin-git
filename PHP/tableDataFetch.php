<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("websiteEntry.php");
$tableName = $_GET['tablename'];
$colNum = intval($_GET['colnum']);
$limit = intval($_GET['limit']);
$currRowNum = (intval($_GET['curr'])-1)*$limit;
$searchWord = trim($_GET['searchword']);

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query("SET NAMES utf8");
 

$query = "SELECT * FROM  $tableName where field_1 like '%$searchWord%' limit $currRowNum,$limit";
$result = mysqli_query($dbc, $query);
$num=mysqli_num_rows($result);
$dataHtml = "";

while ($row = mysqli_fetch_array($result)) {
    $dataHtml .= '<tr>'
            .'<td>'
            . '<a class="layui-btn layui-btn-mini links_edit" data-id="' . $row['id'] . '" ><i class="layui-icon">&#xe642;</i> 编辑</a>'
            . '<a class="layui-btn layui-btn-danger layui-btn-mini links_del" data-id="' . $row['id'] . '"><i class="layui-icon">&#xe640;</i> 删除</a>'
            . '</td>'
            . '<td>' . $row['id'] . '</td>';
    $realColNum = $colNum == 0 ? TOTALFIELDNUMS : $colNum;
    for ($i = 1; $i <= $realColNum; $i++) {
        $dataHtml.= '<td>' . htmlspecialchars($row["field_$i"]). '</td>';
    }
    $dataHtml.=  '</tr>';
}
echo $dataHtml;
mysqli_close($dbc);
