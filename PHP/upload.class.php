<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'connectvars.php';
class upload{
 
  protected $file_path ="../uploadFiles"; //当前files存储文件夹
  #protected $file_size = 1024000;
  protected $file_size = 5120000*20; //5M 用户上传
  protected $file_allow_ext='gif|jpg|jpeg|png|gif|zip|rar|ppt|xls|pdf|pptx|xlsx|docx';
  //检测文件是否为空
 public function check_file($get_file)
 {
    if (empty($get_file))
    {
     $type = "check_file";
       $arr = array('error'=>'empty_name','type'=>$type);
       echo json_encode($arr);
       exit();
    }
  return true;
}
 
 
 //检测文件类型
 public function check_type($get_type)
 {
   if (( $get_type == ".xlsx" ) || ( $get_type == ".xls" )) {
      #$types = $get_type;
   }else{
      $type = "check_type";
      $arr = array('error'=>'format','type'=>$type);
        echo json_encode($arr);
        exit(); 
 
   }
  return true;
 }
 
 //检测文件大小
 public function check_size($get_file)
 {
   if ( $get_file != "" ) {
      if ( $get_file > $this->file_size ) {
          $arr = array('error'=>'large');
          echo json_encode($arr);
          exit();
      }
  }else{
    return false;
    exit();
  }
 return true;
 }
  
//文件保存
 public function save_file($file_type,$file_tmp_name)
 {
  $rand = rand(1000, 9999);
  $pics = date("YmdHis") . $rand . $file_type;
  $path = $this->file_path."/".$pics;
  $result = move_uploaded_file($file_tmp_name, $path);
  if($result){
    return $pics;
  }else{
    return false;
    exit();
  }
  #return $pics;
 }
 
}