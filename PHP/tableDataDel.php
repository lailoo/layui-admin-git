<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$dataId=$_GET['dataid'];
$tableName=$_GET['tablename'];

require ('connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


$query = "delete  FROM ".$tableName." where id='$dataId'";
$numrow =  mysqli_query($dbc, $query);
if($numrow==1){
    echo '200';
}else{
    echo '0';
}
mysqli_close($dbc);