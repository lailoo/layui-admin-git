<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$id = $_POST['id'];
$field_1 = $_POST['field_1'];
$field_2 = $_POST['field_2'];
$field_3 = $_POST['field_3'];
$field_4 = $_POST['field_4'];
$field_5 = $_POST['field_5'];
$field_6 = $_POST['field_6'];
$field_7 = $_POST['field_7'];
$field_8 = $_POST['field_8'];
$field_9 = $_POST['field_9'];
$field_10 = $_POST['field_10'];
$field_11 = $_POST['field_11'];


require("connectvars.php");
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "update " . BASICBUILDINGTABLE_NAME . " set field_1='$field_1',  field_2='$field_2',  field_3='$field_3', "
        . " field_4='$field_4', field_5='$field_5', field_6='$field_6', field_7='$field_7', field_8='$field_8', "
        . " field_9='$field_9', field_10='$field_10', field_11='$field_11' where id='$id'";
$result = mysqli_query($dbc, $query);
echo $query;
if ($result ==1) {
    echo "200";
}
mysqli_close($dbc);

