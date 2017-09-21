<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */;
$num=intval($_GET['num']);
$curr=(intval($_GET['curr'])-1)*$num;
$searchword=trim($_GET['searchword']);

require ('connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$query = "SELECT * FROM t_buildinginfo where field_1 like '%$searchword%'  limit $curr,$num";
$data = mysqli_query($dbc, $query);
$dataHtml = '';

while ($row = mysqli_fetch_array($data)) {

    $dataHtml .= '<tr>'
            . '<td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>'
            . '<td align="left">' . $row['id'] . '</td>'
            . '<td>' . $row['field_1'] . '</td>'
            . '<td>' . $row['field_2'] . '</td>'
            . '<td>' . $row['field_3'] . '</td>'
            . '<td>' . $row['field_4'] . '</td>'
            . '<td>' . $row['field_5'] . '</td>'
            . '<td>' . $row['field_6'] . '</td>'
            . '<td>' . $row['field_7'] . '</td>'
            . '<td>' . $row['field_8'] . '</td>'
            . '<td>' . $row['field_9'] . '</td>'
            . '<td>' . $row['field_10'] . '</td>'
            . '<td>' . $row['field_11'] . '</td>'
            . '<td>'
            . '<a class="layui-btn layui-btn-mini links_edit" data-id="' . $row['id'] . '" ><i class="iconfont icon-edit"></i> 编辑</a>'
            . '<a class="layui-btn layui-btn-danger layui-btn-mini links_del" data-id="' . $row['id'] . '"><i class="layui-icon">&#xe640;</i> 删除</a>'
            . '</td>'
            . '</tr>';
}
echo $dataHtml;
//    echo json_encode($rows);
mysqli_close($dbc);
