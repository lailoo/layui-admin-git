<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("websiteEntry.php");
$dataId = $_GET['dataid'];
$tableName = $_GET['tablename'];
$colNum = intval($_GET['colnum']);


$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query("SET NAMES utf8");

$queryData = "select *  FROM " . $tableName . " where id='$dataId'";
$queryTitle = "select field_2,field_3,field_4,field_5 from  " . SYSTEMTABLENAME . " where field_1='$tableName'";


$dataResult = mysqli_query($dbc, $queryData);
$titleResult = mysqli_query($dbc, $queryTitle);
$dataHtml = '';
$dataRow = mysqli_fetch_array($dataResult);
?>

<form class="layui-form" action="" id="tableEditForm"  tablename="<?php echo $tableName; ?>" colnum="<?php echo $colNum; ?>">
    <div class="layui-form-item"> 
        <label class="layui-form-label">ID</label>
        <div class="layui-input-block">
            <input type="text" name="id" class="layui-input" value="<?php echo $dataRow['id'] ?>" required>
        </div>
    </div>
    <?php
    for ($i = 1; $i <= $colNum; $i++) {
        $titleRow = mysqli_fetch_array($titleResult);
        ?>
        <div class = "layui-form-item">
            <label class = "layui-form-label"><?php echo $titleRow['field_3']; ?></label>
            <div class = "layui-input-block">
                <?php
                $itemOfSelection=trim($titleRow["field_5"]);
                if (empty($itemOfSelection)) {
                    echo "<input class = 'layui-input' name = 'field_$i' value = '" . $dataRow["field_$i"] . "' required>";
                } else {
                    $selectionArray = explode(',', trim($titleRow["field_5"]));
                    echo "<select name='field_$i' lay-verify='' lay-search>";
                    echo "<option value='".htmlspecialchars($dataRow["field_$i"])."'>".htmlspecialchars($dataRow["field_$i"])."</option>";
                    foreach ($selectionArray as $option) {
                        echo "<option value='$option'>$option</option>";
                    }
                    echo '</select>';
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" id="submitedit" lay-submit lay-filter="submitedit">立即提交</button>
            <button class="layui-btn" id="submitcancel">取消</button>
        </div>
    </div>
</form>
