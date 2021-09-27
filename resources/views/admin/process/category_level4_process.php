<?php
include("../includes/top.php");
if(isset($_POST)) 
{
	$level1_id 	   = trim($_REQUEST['level']);
	if($level=='3')
	{
	?>
        <table class="process_table">
             <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Level1 Category:</td>
                <td width="88%">
                    <select name="parent_id" id="parent_id" class="Field300" style="width:251px;" onChange="get_category_level2_details4(this.value)">
                        <option value="">--Please Select Level1 Category--</option>																		
                        <?php
                        $sql_qry="Select cat_id,cat_name from tbl_categories
                        where status='1' and  level='1' and parent_id='0' ";
                        $sql_arr = $db->get_results($sql_qry,ARRAY_A);
                        if($sql_arr)
                        {
                            foreach($sql_arr as $val)
                            {
                                $cat_id = $val['cat_id'];
                                $cat_name = stripcslashes(html_entity_decode($val['cat_name']));														
                        ?>
                        <option value="<?php echo $cat_id;?>"><?php echo $cat_name;?></option>							
                       <?php
                          }
                      }
                    ?>
                    </select>
                    <span class="Required"> *</span>                                            
                </td>
            </tr>
        </table>
	<?php
	}
	else
	{
		echo '-1';
	}
}
?>