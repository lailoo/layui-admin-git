<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require("websiteEntry.php");
$articleTitle = $_POST["articleTitle"];
$content=$_POST['content'];
// $allhtml=$_POST['allhtml'];

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query("SET NAMES utf8");



$tableName=ARTICLETABLENAME;

$query = "select id,field_2,field_3 from  " . SYSTEMTABLENAME . " where field_1='$tableName' order by id asc";
$result = mysqli_query($dbc, $query);
$colNum = mysqli_num_rows($result);


$query="insert into ".$tableName."(";
for($i=1;$i<=$colNum;$i++){
    $query.="field_".$i;
        if($i!=$colNum){
            $query.=",";
    }
}
$query.=") values(";
$query.="'".$articleTitle."',";
$query.="'".$content."'";
// $query.="'".$allhtml."'";
$query.=" )";
// echo($query);

if(mysqli_query($dbc, $query)){
    echo "200";
}else{
    echo mysqli_error($dbc);
}
mysqli_close($dbc);

