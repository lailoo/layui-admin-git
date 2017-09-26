<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require ('websiteEntry.php');
$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;  
setcookie('user_id', '',time()-3600,ROOTDIR, $domain, false);
setcookie('user_name', '',time()-3600,ROOTDIR, $domain, false);
echo "200";
