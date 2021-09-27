<?php
include("../includes/top.php");
if(isset($_POST)) 
{
	$catid 	   = trim($_REQUEST['level5_id']);
	
	$select_level = "select level as level_id from tbl_categories where cat_id='".$catid."' ";
	$level_arr    = $db->get_row($select_level, ARRAY_A);
	$level_id     = $level_arr['level_id']; 

	if($level_id==5)
	{
		$level5_array  =  $db->get_row("select image_name,category_embed_code, category_video_code, cat_small_image1, cat_small_image2, cat_small_image3,more_info_data,mobile_embed_code from tbl_categories where cat_id='".$catid."' and level='5' ",ARRAY_A);
		
	?>
        <table class="process_table">
            
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload small Image1:</td>
                <td width="88%">
                    <input type="file" name="first_image" id="first_image" style="vertical-align:top;"/> <br />
					<span class="Required" style="font-weight:bold;">Upload only jpg, jpeg,png,gif images</span>
               </td>
            </tr>
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload small Image2</td>
                <td width="88%">
                    <input type="file" name="second_image" id="second_image" style="vertical-align:top;"/><br />
					<span class="Required" style="font-weight:bold;">Upload only jpg, jpeg,png,gif images</span>
					
                </td>
            </tr>
			<tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Upload small Image3</td>
                <td width="88%">
                    <input type="file" name="third_image" id="third_image" style="vertical-align:top;"/> <br />
					<span class="Required" style="font-weight:bold;">Upload only jpg, jpeg,png,gif images</span>
                </td>
            </tr>
			<tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">&nbsp;</td>
                <td width="88%">&nbsp;</td>
			 </tr>
             <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Embed Code: <strong>Product</strong></td>
                <td width="88%">
                    <textarea  name="category_embed_code" id="category_embed_code" style="width:582px;height:219px;"></textarea><br />
                    <span class="Required" style="font-weight:bold;">Width:675px;</span>
                </td>
            </tr>
            
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Embed Code: <strong>Video</strong></td>
                <td width="88%">
                    <textarea  name="category_video_code" id="category_video_code" style="width:582px;height:219px;"></textarea>
                    <br />
                    <span class="Required" style="font-weight:bold;">Width:310px;</span>
                </td>
            </tr>
            
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">Embed Code: <strong>Mobile</strong></td>
                <td width="88%">
                    <textarea  name="mobile_embed_code" id="mobile_embed_code" style="width:582px;height:219px;"></textarea><br />
                    <span class="Required" style="font-weight:bold;">Width:250px;</span>
                </td>
            </tr>
            
            <tr>
                <td width="12%" nowrap="nowrap" class="SmallFieldLabel2">More Info Data:</td>
                <td width="88%">
                    <?php
					include_once '../ckeditor/ckeditor.php';  
					$ckeditor = new CKEditor();
					$ckeditor->basePath = '';
					$ckeditor->config['filebrowserBrowseUrl'] = '/ckfinder/ckfinder.html';
					$ckeditor->config['filebrowserImageBrowseUrl'] =	
					'ckeditor/ckfinder/ckfinder.html?type=Images';
					$ckeditor->config['filebrowserFlashBrowseUrl'] = 
					'ckeditor/ckfinder/ckfinder.html?type=Flash';
					$ckeditor->editor('more_info_data','');
					?>
                </td>
            </tr>
        </table>
	<?php
	}
}
?>