<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require("websiteEntry.php");
$tableName = $_GET['tablename'];
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query("SET NAMES utf8");

//修改处
$query = "select id,field_2,field_3 from  " . SYSTEMTABLENAME . " where field_1='$tableName' order by id asc";
$result = mysqli_query($dbc, $query);
$num_row = mysqli_num_rows($result);
$col_width=120;
//var_dump("query:".$query."    tableName:".$tableName."    num_row:".$num_row);
?>

<blockquote class="layui-elem-quote news_search">
    <div class="layui-inline">
        <div class="layui-input-inline">
            <input type="text" value="" placeholder="请输入关键字" class="layui-input search_input" id="searchWord" autocomplete="off">
        </div>
        <a class="layui-btn search_btn">查询</a>
    </div>
    <div class="layui-inline">
        <a class="layui-btn linksAdd_btn" style="background-color:#5FB878">添加链接</a>
    </div>

</blockquote>
<div class="childrenBody ">
    <div class="layui-form links_list " >
        <table  lay-filter="curr_table" id="curr_table" tablename="<?php echo $tableName ?>"  colnum="<?php echo $num_row == 0 ? TOTALFIELDNUMS : $num_row ?>">
            <thead>
                <tr>
                    <th lay-data="{field:'id',width:80,sort:true}">ID</th>
                    <?php
                    if ($num_row == 0) {
                        
                        for ($i = 1; $i <= TOTALFIELDNUMS; $i++) {
                            $curr_col_width=0;
                            if($i==2&&$tableName==ARTICLETABLENAME){
                                $curr_col_width=$col_width*6;
                            }else{
                                $curr_col_width=$col_width;
                            }
                            echo "<th lay-data=\"{field:'field_$i',width:$curr_col_width,sort:true}\">field_$i</th>";
                        }
                    } else {
                        $i=1;
                        while ($row = mysqli_fetch_array($result)) {
                            $curr_col_width=0;
                            if($i==2&&$tableName==ARTICLETABLENAME){
                                $curr_col_width=$col_width*6;
                            }else{
                                $curr_col_width=$col_width;
                            }
                            echo "<th lay-data=\"{field:'field_$i',width:$curr_col_width,sort:true}\">".$row['field_3']."</th>";
                            $i++;
                        }
                    }
                    ?>
                    <th lay-data={field:'operation',width:150}>操作</th>
                </tr> 
            </thead>
            <tbody class="links_content"></tbody>
        </table>
        <div id="page" ></div>
    </div>
</div>

<?php
mysqli_close($dbc);
?>
