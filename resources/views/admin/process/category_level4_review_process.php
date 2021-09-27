<?php
include("../includes/top.php");
if(isset($_POST)) 
{
	$level3_id 	   = trim($_REQUEST['level3_id']);
	
	$select_level = "select count(cat_id) as leve4_cats_counter from tbl_categories where cat_id='".$level3_id."' 
	and level='3'";
	$level_arr    		= $db->get_row($select_level, ARRAY_A);
	$leve4_cats_counter = $level_arr['leve4_cats_counter']; 
	if($leve4_cats_counter>0)
	{
	?>
        <table class="process_table">
             <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Level4 Category:</td>
                <td width="88%">
                    <select name="level4_cat_id" id="level4_cat_id" style="width:300px;padding:4px 1px;" onChange="get_category_level5_review(this.value)">
       					<option value="">--Please Select Level4 Category--</option>																		
                        <?php
                        $sql_qry="Select cat_id,cat_name from tbl_categories
                        where status='1' and  level='4' and parent_id='".$level3_id."' ";
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
	
}
?>