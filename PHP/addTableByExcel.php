<?php

include './excelToMysql.php';
$file_upload = "../uploadFiles/"; //excel文件上传临时存储位置
$file_allow_ext = 'xls|xlsx';
$file_allow_size = 100 * 1024 * 1024; //最大100M
//if ($_POST['excelFileUpload']) {
if (is_uploaded_file($_FILES['excelDataFile']['tmp_name'])) {
    $file_name = $_FILES['excelDataFile']['name'];
    $file_error = $_FILES['excelDataFile']['error'];
    $file_type = $_FILES['excelDataFile']['type'];
    $file_tmp_name = $_FILES['excelDataFile']['tmp_name'];
    $file_size = $_FILES['excelDataFile']['size'];

    $file_ext = substr($file_name, strrpos($file_name, '.') + 1);

    $tableName = $_POST['tablename'];
    $tableTitle = $_POST['tabletitle'];

    switch ($file_error) {
        case 0:
            $data['status'] = 0;
            $data['msg'] = "文件上传成功!";
            break;

        case 1:
            $data['status'] = 1;
            $data['msg'] = "文件上传失败，文件大小" . $file_size . "超过限制,允许上传大小" . sizeFormat($file_allow_size) . "!";
            break;

        case 3:
            $data['status'] = 1;
            $data['msg'] = "上传失败，文件只有部份上传!";
            break;

        case 4:
            $data['status'] = 1;
            $data['msg'] = "上传失败，文件没有被上传!";
            break;

        case 5:
            $data['status'] = 1;
            $data['msg'] = "文件上传失败，文件大小为0!";
            break;
    }
    if (stripos($file_allow_ext, $file_ext) === false) {
        $data['status'] = 1;
        $data['msg'] = "请选择Excel文件格式";
    }
    if ($file_size > $file_allow_size) {
        $data['status'] = 1;
        $data['msg'] = "文件大小超过限制,只能上传" . sizeFormat($file_allow_size) . "的文件!";
    }
    if ($data['status'] == 1) {
        $data['status'] = 1;
        $data['msg'] = $data['msg'];
        exit(json_encode($data));
    }
    if ($data['status'] == 0) {
        $data=createTable($tableName, $tableTitle, $data);
        if($data['status'] != 0){
            exit(json_encode($data));
        }
        if (file_exists($file_upload)) {
            $file_new_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            $file_save_path = $file_upload . $file_new_name;
            $data['status'] = 0;
            $data['url'] = $file_save_path;
            move_uploaded_file($file_tmp_name, $file_save_path);

            $data = importExcelToMysql($file_save_path, $data);
            unlink($file_save_path);
            exit(json_encode($data));
        } else {
            $data['status'] = 1;
            $data['msg'] = "'" . $file_upload . "'目录文件不存在,字段元数据信息导入失败！";
            exit(json_encode($data));
        }
    }
}

//}
function createTable($tablename, $tabletitle, $data) {

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $dbc->query("SET NAMES utf8");
    
    $query = "call proc_creattable('$tablename',35);";
    
    if (mysqli_query($dbc, $query)) {
        $data["status"] = 0;
        //表格相关元数据清理工作
        $query_delete_tablemeta="delete from t_tablemetainfo where field_1=$tablename;";
        mysqli_query($dbc, $query_delete_tablemeta);
        $query_delete_fieldmeta="delete from ".SYSTEMTABLENAME." where field_1=$tablename;";
        mysqli_query($dbc, $query_delete_fieldmeta);
        
        
        //插入表格相关的元数据信息包括表格描述信息和字段信息
        $query_insert = "insert into t_tablemetainfo (field_1,field_2,field_3,field_4) values('$tablename','$tabletitle','&#xe61c;','');";
        if(!mysqli_query($dbc, $query_insert)){
            $data["status"] = 1;
            $data["msg"] = "表格元数据信息插入失败，错误信息：".mysqli_error($dbc);
        }
    } else {
        $data["status"] = 1;
        $data["msg"] = "创建数据表失败，错误信息：" . mysqli_error($dbc);
    }
    mysqli_close($dbc);
    if($data["status"] == 1){
        json_encode($data);
        
    }  else {
        return $data;
    }
    
}

function sizeFormat($size) {
    $sizeStr = '';
    if ($size < 1024) {
        return $size . "bytes";
    } else if ($size < (1024 * 1024)) {
        $size = round($size / 1024, 1);
        return $size . "KB";
    } else if ($size < (1024 * 1024 * 1024)) {
        $size = round($size / (1024 * 1024), 1);
        return $size . "MB";
    } else {
        $size = round($size / (1024 * 1024 * 1024), 1);
        return $size . "GB";
    }
}

?>