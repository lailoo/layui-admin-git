<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("websiteEntry.php");
$tableName = $_GET['tablename'];
$searchWord = trim($_GET['searchword']);


$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$query = "SELECT * FROM $tableName where field_1 like '%$searchWord%'";
$result = mysqli_query($dbc, $query);
echo mysqli_num_rows($result);
mysqli_close($dbc);