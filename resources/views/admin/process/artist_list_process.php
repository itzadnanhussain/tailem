<?php

include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");
error_reporting(0);
if(isset($_POST)) 
{
	$errorstr="";
	$case = 1;
	
	$pass_val = $_REQUEST['pass_val'];
	
														
				 	$artist_list="select id, artist_name from tbl_artists where 1=1 AND artist_status = 1 AND  artist_name like '$pass_val%'   order by artist_name asc";	
						
					$artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);
					
					 if(isset($artist_list_arr))
					{
						$u = 0;
						?>
						  <div style="width: 661px; height: 220px; overflow-y: scroll; border: solid 1px #000000;" id="hide_first">
						  <?php
						foreach($artist_list_arr as $val)
						{
							$id	  = $val['id'];	
							$artist_name = stripslashes(html_entity_decode($val['artist_name']));
							if(in_array($id,$sep_arr))
							{
								$selected = "checked";
							}
							else
							{
								$selected = "";
							}
							
							
							?>
						   <input type="checkbox" name="artist[]" id="artist_<?php echo $u;?>" value="<?php echo $id;?>" <?php echo $selected;?> onchange="artist_check(this.value)" > <?php echo $artist_name;?> <br>
							
							<?php
							$u++;
						}
						?>
						</div>
						<?php
						
					}
					
										
										?>
    <?php
	if($case==1)
	{
		//echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
