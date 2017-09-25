<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("websiteEntry.php");
$id = $_GET['id'];
$tableName = $_GET['tablename'];
$colNum = intval($_GET['colnum']);



$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query("SET NAMES utf8");
$query = "update " . $tableName." set" ;
for($i=1;$i<=$colNum;$i++){
   $query.= "  field_$i='".$_GET["field_".$i]."'";
   if($i!=$colNum){
       $query.=",";
   }
}
$query.=" where id='$id'";

$result = mysqli_query($dbc, $query);
if ($result ==1) {
    echo "200";
}
mysqli_close($dbc);
