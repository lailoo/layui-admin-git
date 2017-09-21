<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tableName = $_GET['tablename'];
require ('connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$query = "SELECT * FROM $tableName";
$result = mysqli_query($dbc, $query);
echo mysqli_num_rows($result);
mysqli_close($dbc);