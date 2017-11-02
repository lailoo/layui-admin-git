<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './connectvars.php';

$nav = array();

//后台首页
$navItem = array();

$navItem["href"] = "page/main.html";
$navItem["title"] = "后台首页";
$navItem["icon"] = "icon-computer";
$navItem["spread"] = FALSE;
$nav[] = $navItem;

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("不能连接到数据库");
$dbc->query("SET NAMES utf8");
$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 't_publicbuildingdb'";
$result = mysqli_query($dbc, $query);
$num_row = mysqli_num_rows($result);
$tableList = array();
while ($row = mysqli_fetch_array($result)) {
    $tableList[] = $row["TABLE_NAME"];
}
foreach ($tableList as $tableName) {
    $query = "select id,field_1,field_2,field_3 from  " . TABLEMETAINFOTABLE_NAME . " where field_1='$tableName'";
    $result = mysqli_query($dbc, $query);
    $num_row = mysqli_num_rows($result);
    if ($num_row != 0) {
        while ($row = mysqli_fetch_array($result)) {
            $navItem = array();
            $navItem["href"] = trim(strtolower($row["field_1"]));
            $navItem["title"] = trim(strtolower($row["field_2"]));
            $navItem["icon"] = trim(strtolower($row["field_3"]));
            $navItem["spread"] = FALSE;
            $nav[] = $navItem;
        }
    }
}
mysqli_close($dbc);

exit(json_encode($nav));







