<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('connectvars.php');
if(!isset($_COOKIE['user_id'])){
    $login_url=HOMEDIR."PHP/login.php";
    header("Location:".$login_url);
    exit;
}

