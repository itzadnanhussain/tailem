<?php
include("../includes/top.php");
if(isset($_POST)) 
{
	$catid 	   = trim($_REQUEST['level4_id']);
	$record_id = trim($_REQUEST['record_id']);
	
	$select_level = "select level as level_id from tbl_categories where cat_id='".$catid."' ";
	$level_arr    = $db->get_row($select_level, ARRAY_A);
	$level_id     = $level_arr['level_id']; 

	if($level_id==4)
	{
	?>
        <table class="process_table">
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload Main Image:</td>
                <td width="88%">
                    <input type="file" name="image_name" id="image_name"/> <br />
                    <span class="Required" style="font-weight:bold;">Upload only jpg, jpeg,png,gif images</span>
                </td>
            </tr>
             <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload small Images:</td>
                <td width="88%">
                    <input type="file" name="cat_img_name1" id="cat_img_name1"/> <br />
                    <input type="file" name="cat_img_name2" id="cat_img_name2"/> <br />
                    <input type="file" name="cat_img_name3" id="cat_img_name3"/> <br />
                    <span class="Required" style="font-weight:bold;">Upload only jpg, jpeg,png,gif images</span>
                </td>
            </tr>
            
             <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Embed Code: <strong>Product</strong></td>
                <td width="88%">
                    <textarea  name="embed_code_product" id="embed_code_product" style="width:582px;height:219px;"></textarea><br />
                    <span class="Required" style="font-weight:bold;">Width:630px;</span>
                </td>
            </tr>
            
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Embed Code: <strong>Video</strong></td>
                <td width="88%">
                    <textarea  name="embed_code_video" id="embed_code_video" style="width:582px;height:219px;"></textarea>
                    <br />
                    <span class="Required" style="font-weight:bold;">Width:310px;</span>
                </td>
            </tr>
        </table>
	<?php
	}
	elseif($level_id==5)
	{
		$video_row = $db->get_row("select video_id,video_cat_id, video_code from tbl_videos where video_cat_id='".$catid."'  ",ARRAY_A);
		$video_id     = $video_row['video_id'];
		$video_code   = stripslashes(html_entity_decode($video_row['video_code']));
		
		$embed_row = $db->get_row("select embed_code_id, embed_code from tbl_product_embed_code where embed_cat_id='".$catid."'  ",ARRAY_A);
	
		$embed_code_id     = $embed_row['embed_code_id'];
		$embed_code        = stripslashes(html_entity_decode($embed_row['embed_code']));
	?>
        <table class="process_table">
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">5Upload Main Image:</td>
                <td width="88%">
                    <input type="file" name="image_name" id="image_name"/> <br />
                    <span class="Required" style="font-weight:bold;">Upload only jpg, jpeg,png,gif images</span>
                </td>
            </tr>
             <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload small Images:</td>
                <td width="88%">
                    <input type="file" name="cat_img_name1" id="cat_img_name1"/> <br />
                    <input type="file" name="cat_img_name2" id="cat_img_name2"/> <br />
                    <input type="file" name="cat_img_name3" id="cat_img_name3"/> <br />
                    <span class="Required" style="font-weight:bold;">Upload only jpg, jpeg,png,gif images</span>
                </td>
            </tr>
            
             <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Embed Code: <strong>Product</strong></td>
                <td width="88%">
                    <textarea  name="embed_code_product" id="embed_code_product" style="width:582px;height:219px;"><?php echo $embed_code;?></textarea><br />
                    <span class="Required" style="font-weight:bold;">Width:630px;</span>
                </td>
            </tr>
            
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Embed Code: <strong>Video</strong></td>
                <td width="88%">
                    <textarea  name="embed_code_video" id="embed_code_video" style="width:582px;height:219px;"><?php echo $video_code;?></textarea>
                    <br />
                    <span class="Required" style="font-weight:bold;">Width:310px;</span>
                </td>
            </tr>
        </table>
	<?php
	}
}
?>