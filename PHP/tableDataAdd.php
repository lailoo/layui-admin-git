<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require("connectvars.php");
$tableName = $_GET["tablename"];

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$query = "select field_2,field_3,field_4,field_5 from  " . SYSTEMTABLENAME . " where field_1='$tableName'";
$dbc->query("SET NAMES utf8");
$result = mysqli_query($dbc, $query);
$num_row = mysqli_num_rows($result);
?>

<form class="layui-form" tablename="<?php echo $tableName; ?>" colnum="<?php echo $num_row == 0 ? TOTALFIELDNUMS : $num_row; ?>" 
      action="" id="tableDataAddForm">
          <?php
          if ($num_row == 0) {
              for ($i = 1; $i < TOTALFIELDNUMS; $i++) {
                  ?>
            <div class="layui-form-item">
                <label class="layui-form-label">field_<?php echo $i; ?></label>
                <div class="layui-input-block">
                    <input class="layui-input" name="field_<?php echo $i; ?>"  value="" >
                </div>
            </div>
            <?php
        }
    } else {
        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo $row["field_3"]; ?></label>
                <div class="layui-input-block">
                    <?php
                    $itemOfSelection=trim($row["field_5"]);
                    if (empty($itemOfSelection)) {
                        echo "<input class = 'layui-input' name = 'field_$i' value = '' required>";
                    } else {
                        $selectionArray = explode(',', trim($row["field_5"]));
                        echo "<select name='field_$i' lay-verify='' lay-search>";
                        echo "<option value=''></option>";
                        foreach ($selectionArray as $option) {
                            echo "<option value='$option'>$option</option>";
                        }
                        echo '</select>';
                    }
                    ?>


                </div>
            </div>
            <?php
            $i++;
        }
    }
    mysqli_close($dbc);
    ?>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" id="submitadd" >添加信息</button>
            <button class="layui-btn" id="submitcancel">取消</button>
        </div>
    </div>
</form>
