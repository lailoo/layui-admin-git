<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ExcelToArrary {

    public function __construct() {
        //引用连接数据库文件和PHPExcel文件，在php文件上面加上代码
        include_once './connectvars.php';
        
        include_once('./Excel/PhpExcelClasses/PHPExcel.php');
        include_once './Excel/PhpExcelClasses/IOFactory.php';
        include_once './Excel/PhpExcelClasses/Reader/Excel5.php';
        
    }

    /**
     * 读取excel $filename 路径文件名 $encode 返回数据的编码 默认为utf8
     * 以下基本都不要修改
     */
    public function read($filename,$filetype,$data,$encode = 'utf-8') {
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row][] = (string) $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }

}
