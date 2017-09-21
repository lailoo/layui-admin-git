<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$dataId = $_GET['dataid'];

require ('connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "select *  FROM ".BASICBUILDINGTABLE_NAME." where id='$dataId'";
$result = mysqli_query($dbc, $query);
$dataHtml = '';
$row = mysqli_fetch_array($result);
?>

<form class="layui-form" action="" id="editform">

    <div class="layui-form-item">
        <label class="layui-form-label">建筑ID</label>
        <div class="layui-input-block">
            <input type="text" name="id" class="layui-input" value="<?php echo $row['id'] ?>" required>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">建筑名称</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_1" value="<?php echo $row["field_1"] ?>" required>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">建筑类型</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_2" value="<?php echo $row["field_2"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">气候区</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_3" value="<?php echo $row["field_3"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所在城市</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_4" value="<?php echo $row["field_4"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">建筑面积</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_5" value="<?php echo $row["field_5"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">楼层数</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_6" value="<?php echo $row["field_6"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">业主单位</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_7" value="<?php echo $row["field_7"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系方式</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_8" value="<?php echo $row["field_8"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">建造时间</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_9" value="<?php echo $row["field_9"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">改造时间</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_10" value="<?php echo $row["field_10"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <input class="layui-input" name="field_11" value="<?php echo $row["field_11"] ?>" >
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" id="submitedit" lay-submit lay-filter="submitedit">立即提交</button>
            <button class="layui-btn" id="submitcancel">取消</button>
        </div>
    </div>
</form>


