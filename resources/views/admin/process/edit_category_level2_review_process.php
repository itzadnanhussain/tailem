<?php
include("../includes/top.php");
if(isset($_POST)) 
{
	$level1_id 	= trim($_REQUEST['level1_id']);
	$reviews_id = trim($_REQUEST['reviews_id']);
	
	$select_level = "select count(cat_id) as level2_cats_counter from tbl_categories where cat_id='".$level1_id."' 
	and level='1'";
	$level_arr    		 = $db->get_row($select_level, ARRAY_A);
	$level2_cats_counter = $level_arr['level2_cats_counter']; 

	if($level2_cats_counter>0)
	{
	?>
        <table class="process_table">
             <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Level2 Category:</td>
                <td width="88%">
                    <select name="level2_cat_id" id="level2_cat_id" style="width:300px;padding:4px 1px;" onChange="edit_category_level3_review(this.value,'<?php echo $reviews_id;?>')">
       					<option value="">--Please Select Level2 Category--</option>																		
                        <?php
                        $sql_qry="Select cat_id,cat_name from tbl_categories
                        where status='1' and  level='2' and parent_id='".$level1_id."' ";
                        $sql_arr = $db->get_results($sql_qry,ARRAY_A);
                        if($sql_arr)
                        {
                            foreach($sql_arr as $val)
                            {
                                $cat_id = $val['cat_id'];
                                $cat_name = stripcslashes(html_entity_decode($val['cat_name']));
								
								$level2_qry = "select cat_level2 from tbl_reviews where review_id='".$reviews_id."'";
								$level2_arr = $db->get_row($level2_qry,ARRAY_A);
								$selected_level2_id  = $level2_arr['cat_level2'];
																						
                                if($selected_level2_id==$cat_id)
                                {
                                    $selected= "selected='selected'";
                                }
                                else
                                {
                                    $selected= "";
                                }
                        ?>
                        <option value="<?php echo $cat_id;?>" <?php echo $selected;?>><?php echo $cat_name;?></option>							
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