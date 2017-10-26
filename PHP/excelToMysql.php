<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './connectvars.php';

include_once './Excel/PhpExcelClasses/PHPExcel.php';
include_once './Excel/PhpExcelClasses/PHPExcel/IOFactory.php';
include_once './Excel/PhpExcelClasses/PHPExcel/Reader/Excel5.php';
include_once './Excel/PhpExcelClasses/PHPExcel/Reader/Excel2007.php';

/**
 *  数据导入 
 * @param string $file excel文件 
 * @param string $sheet 
 * @return string   返回解析数据 
 * @throws PHPExcel_Exception 
 * @throws PHPExcel_Reader_Exception 
 */
function excelToArray($filename, $sheet = 0) {
    $file = iconv("UTF-8", "GB2312//IGNORE", $filename); //转码  
    if (empty($file) OR ! file_exists($file)) {
        die('file not exists!');
    }
    $objRead = new PHPExcel_Reader_Excel2007();   //建立reader对象  
    if (!$objRead->canRead($file)) {
        $objRead = new PHPExcel_Reader_Excel5();
        if (!$objRead->canRead($file)) {
            die('No Excel!');
        }
    }

    $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

    $obj = $objRead->load($file);  //建立excel对象  
    $currSheet = $obj->getSheet($sheet);   //获取指定的sheet表  
    $columnH = $currSheet->getHighestColumn();   //取得最大的列号  
    $columnCnt = array_search($columnH, $cellName);
    $rowCnt = $currSheet->getHighestRow();   //获取总行数  
    $arrayExcelData = array();

    for ($_row = 1; $_row <= $rowCnt; $_row++) {  //读取内容  
        for ($_column = 0; $_column <= $columnCnt; $_column++) {
            $cellId = $cellName[$_column] . $_row;
            $cellValue = $currSheet->getCell($cellId)->getValue();
            //$cellValue = $currSheet->getCell($cellId)->getCalculatedValue();  #获取公式计算的值  
            if ($cellValue instanceof PHPExcel_RichText) {   //富文本转换字符串  
                $cellValue = $cellValue->__toString();
            }
            //从1开始计数
            $arrayExcelData[$_row][$_column] = trim(strtolower($cellValue));
        }
    }
    //注意 返回的数组一维坐标以1开始，而第二维则是以0开始
    return $arrayExcelData;
}
//测试语句
//var_dump(importExcelToMysql("../uploadFiles/20171023133002_19450.xlsx",array()));
function importExcelToMysql($filename,$runResult, $sheet = 0) {
    $runResult["status"]=0;
    $arrayExcelData = excelToArray($filename);
    //获取表格标题列的个数
//    $fieldnum=  count($arrayExcelData[1]);
    $searchResult = identifyTargetTable($arrayExcelData[1]);
    
    $firstCol=trim(strtolower($arrayExcelData[1][0]));
    
    unset($arrayExcelData[1]); //删除标题行
    if ($searchResult["result"]) {
        $tablename = $searchResult["tablename"];
        $fieldnum = $searchResult["validColNum"];

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $dbc->query("SET NAMES utf8");
        $queryPrefix = "insert into " . $tablename . "(";
        if($firstCol=="id"){
            $queryPrefix.="id,";
        }
        
        for ($i = 1; $i <= $fieldnum; $i++) {
            $queryPrefix.="field_" . $i;
            if ($i != $fieldnum) {
                $queryPrefix.=",";
            }
        }
        $queryPrefix.=") values(";
        //判断是否有ID
        $effectColNum=$firstCol=="id"?$fieldnum+1:$fieldnum;
        foreach ($arrayExcelData as $value) {
            $query = $queryPrefix;
            for ($i = 0; $i < $effectColNum; $i++) {
                $query.="'" . $value[$i] . "'";
                if ($i != ($effectColNum-1)) {
                    $query.=",";
                }
            }
            $query.=" )";
//            var_dump($query);
            if(!mysqli_query($dbc, $query)){
                    $runResult["status"]=1;
                    $runResult["msg"]=$query;
                    $runResult;
            }
        }
        
        
        
    }  else {
        $runResult["status"]=1;
        $runResult["msg"]="无法匹配到数据库表，请检查Excel文件标题！";
    }
    mysqli_close($dbc);
    return $runResult;
}

/**
 * 获取目标表名
 * @param Array $tableTitleArray Description
 * @return string 表名
 */
// sql语句：SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 't_publicbuildingdb'
function identifyTargetTable($tableTitleArray) {
    $searchResult = array();
    $searchResult["result"] = FALSE;
    if ($tableTitleArray[0] == "id") {
        unset($tableTitleArray[0]);
    }
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("不能连接到数据库");
    $dbc->query("SET NAMES utf8");
    $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 't_publicbuildingdb'";
    $result = mysqli_query($dbc, $query);
    $num_row = mysqli_num_rows($result);
    $tableNameList = array();
    while ($row = mysqli_fetch_array($result)) {
        $tableNameList[] = $row["TABLE_NAME"];
    }
    foreach ($tableNameList as $tableName) {
        $query = "select id,field_3 from  " . SYSTEMTABLENAME . " where field_1='$tableName' order by id asc";
        $result = mysqli_query($dbc, $query);
        $num_row = mysqli_num_rows($result);
        if ($num_row != 0) {
            $tableFieldTitleList = array();
            while ($row = mysqli_fetch_array($result)) {
                $tableFieldTitleList[] = trim(strtolower($row["field_3"]));
            }
            foreach ($tableTitleArray as $key => $value) {
                if($value==""){
                    unset($tableTitleArray[$key]);
                }
                    
            }
            if (count($tableTitleArray) == count($tableFieldTitleList) && containArray($tableTitleArray, $tableFieldTitleList)) {
                $searchResult["result"] = TRUE;
                $searchResult["tablename"] = $tableName;
                $searchResult["validColNum"]=count($tableTitleArray);
//                $searchResult["fieldnum"] = count($tableFieldTitleList);
                break;
            }
        }
    }
    mysqli_close($dbc);
    return $searchResult;
}

function containArray($a, $b) {
    $flag = 1;
    foreach ($a as $va) {
        if (in_array($va, $b)) {
            continue;
        } else {
            $flag = 0;
            break;
        }
    }

    if ($flag) {
        return true;
    } else {
        return false;
    }
}


