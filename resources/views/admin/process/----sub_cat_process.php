<?php
include("../includes/top.php");
include(dirname(dirname(__FILE__))."/common/thumbnail.class.php");
error_reporting(0);
if(isset($_POST)) 
{
	$path= '../../site_upload/category_images/';
	$errorstr="";
	$case = 1;
	$cat_name  	  = trim($_REQUEST['cat_name']);
	$parent_id    = trim($_REQUEST['parent_id']);
	$search_label = trim($_REQUEST['search_label']);
	$search_name  = trim($_REQUEST['search_name']);
	$image_name   = $_FILES["image_name"]['name'];
	$description  = trim($_REQUEST['description']);
	$update_id = trim($_REQUEST['update_id']);
	if($cat_name == "")
	{
		$errorstr .="Please Enter Category Name\n";
		$case = 0;
	}
	else
	{
		if($update_id=="")
		{
			$chk_name_qry ='select cat_name as chk_name from tbl_categories where cat_name  = \''.$cat_name.'\' and 
			parent_id="'.$parent_id.'" ';
		}
		else
		{
			$chk_name_qry ='select cat_name as chk_name from tbl_categories where cat_name  = \''.$cat_name.'\' and 
			parent_id="'.$parent_id.'" and cat_id!="'.$update_id.'" ';
		}
		$chk_name_arr = $db->get_row($chk_name_qry, ARRAY_A);
		$chk_name     = $chk_name_arr['chk_name'];	
		if($chk_name!="")
		{
			$errorstr .="This Category Name already Exsist\n";
			$case = 0;
		}
	}
	if($parent_id == "")
	{
		$errorstr .="Please Enter Parent Category\n";
		$case = 0;
	}
	else
	{
		if($update_id=="")
		{
			$chk_parent_qry ='select cat_id as chk_parent_id from tbl_categories where cat_id="'.$parent_id.'" and 
			level<=4';
		}
		else
		{
			$chk_parent_qry ='select cat_id as chk_parent_id from tbl_categories where (cat_id="'.$parent_id.'" OR 
			cat_id="'.$update_id.'") and level<=4';
		}
		$chk_parent_arr = $db->get_row($chk_parent_qry, ARRAY_A);
		$chk_parent_id  = $chk_parent_arr['chk_parent_id'];	
		if($chk_parent_id=="")
		{
			$errorstr .="Invalid Parent category is selected\n";
			$case = 0;
		}
		
		if($update_id!="" && $chk_parent_id!="")
		{
			$child_level_qry ='select level as child_level from tbl_categories where cat_id="'.$update_id.'"';
			$child_level_arr = $db->get_row($child_level_qry, ARRAY_A);
			$child_level     = $child_level_arr['child_level'];	
			
			$parent_level_qry ='select level as parent_level from tbl_categories where cat_id="'.$parent_id.'"';
			$parent_level_arr = $db->get_row($parent_level_qry, ARRAY_A);
			$parent_level     = $parent_level_arr['parent_level'];
			
			$new_parent_level = $parent_level+1;
			$old_parent_level = $child_level-1;
			
			if($child_level!=$new_parent_level)
			{
				$errorstr .="Please select correct level".$old_parent_level." Parent id\n";
				$case = 0;
			}
			
		}
	}
	/*if($description == "")
	{
		$errorstr .="Please Enter Description\n";
		$case = 0;
	}
	if($search_label == "")
	{
		$errorstr .="Please Enter Search Label\n";
		$case = 0;
	}
	if($search_name == "")
	{
		$errorstr .="Please Enter Search Name\n";
		$case = 0;
	}
	if($_FILES["image_name"]['name']=="" && $update_id=="")
	{
		$errorstr .= "Please Upload Image\n";
		$case = 0;
	}
	else*/
	if($_FILES["image_name"]['name']!="")
	{
		$filename = $_FILES["image_name"]['name'];
		$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
		$ext = array('jpg', 'png', 'gif','JPEG','jpeg');
		if(!in_array($TmpExt,$ext))
		{
			$errorstr .= "Invalid Image Format\n";
			$case = 0;
		}
	}
	if($case==1)
	{
		$select_level = "select level as parent_level from tbl_categories where cat_id='".$parent_id."' ";
		$level_arr    = $db->get_row($select_level, ARRAY_A);
		$parent_level = $level_arr['parent_level'];
		$level        = $parent_level+1;
		$cat_seo_name = clean_url_seo($cat_name);
		$root_parent_id = category_level($parent_id,$db); 		
		/*if($root_parent_id=="" && $level==2)
		{
			$root_parent_id = $parent_id;
		}*/
		if($level==5 && $parent_id!="")
		{
			$select_level3 = "select parent_id as plevel3 from tbl_categories where cat_id='".$parent_id."' ";
			$level_arr3    = $db->get_row($select_level3, ARRAY_A);
			$plevel3 = $level_arr3['plevel3'];
			
			$select_level2 = "select parent_id as plevel2 from tbl_categories where cat_id='".$plevel3."' ";
			$level_arr2    = $db->get_row($select_level2, ARRAY_A);
			$plevel2 = $level_arr2['plevel2'];
		}
		elseif($level==4 && $parent_id!="")
		{
			$plevel3 = $parent_id;
			
			$select_level2 = "select parent_id as plevel2 from tbl_categories where cat_id='".$parent_id."' ";
			$level_arr2    = $db->get_row($select_level2, ARRAY_A);
			$plevel2 = $level_arr2['plevel2'];
		}
		elseif($level==3 && $parent_id!="")
		{			
			$plevel2 = $parent_id;
		}
		if($update_id=="")
		{
			$insert_qry="INSERT INTO tbl_categories SET cat_name='".mysqli_escape_string($db->dbh, stripslashes($cat_name))."',parent_id='".mysqli_escape_string($db->dbh, stripslashes($parent_id))."',status='1',level='".$level."', cat_seo_name='".mysqli_escape_string($db->dbh, stripslashes($cat_seo_name))."',root_parent_id='".$root_parent_id."',description='".mysqli_escape_string($db->dbh, stripslashes($description))."' ,plevel2='".mysqli_escape_string($db->dbh, stripslashes($plevel2))."',plevel3='".mysqli_escape_string($db->dbh, stripslashes($plevel3))."' ";
			$db->query($insert_qry);
			$last_record = mysqli_insert_id($db->dbh);
		}
		else
		{
			$update_qry ="UPDATE tbl_categories SET cat_name='".mysqli_escape_string($db->dbh, stripslashes($cat_name))."',parent_id='".mysqli_escape_string($db->dbh, stripslashes($parent_id))."',level='".$level."',cat_seo_name='".mysqli_escape_string($db->dbh, stripslashes($cat_seo_name))."',root_parent_id='".$root_parent_id."',description='".mysqli_escape_string($db->dbh, stripslashes($description))."' ,plevel2='".mysqli_escape_string($db->dbh, stripslashes($plevel2))."',plevel3='".mysqli_escape_string($db->dbh, stripslashes($plevel3))."' where cat_id='".$update_id."' ";
			$db->query($update_qry);
			$last_record = $update_id;
			if($level==5)
			{
				$level4_qry ="Select cat_id as cat_level4,parent_id as level4_parent from tbl_categories where cat_id='".$parent_id."' and level='4'";
				$level4_arr    = $db->get_row($level4_qry,ARRAY_A);
				$cat_level4    = $level4_arr['cat_level4'];
				$level4_parent = $level4_arr['level4_parent'];
				
				$level3_qry ="Select cat_id as level3_id,parent_id as level3_parent from tbl_categories where cat_id='".$level4_parent."' and level='3' ";
				$level3_arr    = $db->get_row($level3_qry,ARRAY_A);
				$cat_level3     = $level3_arr['level3_id'];
				$level3_parent = $level3_arr['level3_parent'];
				
				$level2_qry ="Select cat_id as level2_id,parent_id as level2_parent from tbl_categories where cat_id='".$level3_parent."' and level='2' ";
				$level2_arr    = $db->get_row($level2_qry,ARRAY_A);
				$cat_level2     = $level2_arr['level2_id'];
				$level2_parent = $level2_arr['level2_parent'];
				
				$level1_qry ="Select cat_id as level1_id from tbl_categories where cat_id='".$level2_parent."' and level='1' ";
				$level1_arr    = $db->get_row($level1_qry,ARRAY_A);
				$cat_level1     = $level1_arr['level1_id'];
				
				$update_qry ="UPDATE tbl_reviews SET cat_level1='".$cat_level1."',cat_level2='".$cat_level2."',cat_level3='".$cat_level3."',cat_level4='".$cat_level4."' where category_id='".$update_id."' ";
				$db->query($update_qry);
			}
			elseif($level==4)
			{
				$level3_qry ="Select cat_id as level3_id,parent_id as level3_parent from tbl_categories where cat_id='".$parent_id."' and level='3' ";
				$level3_arr    = $db->get_row($level3_qry,ARRAY_A);
				$cat_level3     = $level3_arr['level3_id'];
				$level3_parent = $level3_arr['level3_parent'];
				
				$level2_qry ="Select cat_id as level2_id,parent_id as level2_parent from tbl_categories where cat_id='".$level3_parent."' and level='2' ";
				$level2_arr    = $db->get_row($level2_qry,ARRAY_A);
				$cat_level2     = $level2_arr['level2_id'];
				$level2_parent = $level2_arr['level2_parent'];
				
				$level1_qry ="Select cat_id as level1_id from tbl_categories where cat_id='".$level2_parent."' and level='1' ";
				$level1_arr    = $db->get_row($level1_qry,ARRAY_A);
				$cat_level1     = $level1_arr['level1_id'];
				
				$update_qry ="UPDATE tbl_reviews SET cat_level1='".$cat_level1."',cat_level2='".$cat_level2."',cat_level3='".$cat_level3."' where cat_level4='".$update_id."'";
				$db->query($update_qry);
			}
			elseif($level==3)
			{
				
				$level2_qry ="Select cat_id as level2_id,parent_id as level2_parent from tbl_categories where cat_id='".$parent_id."' and level='2' ";
				$level2_arr    = $db->get_row($level2_qry,ARRAY_A);
				$cat_level2     = $level2_arr['level2_id'];
				$level2_parent = $level2_arr['level2_parent'];
				
				$level1_qry ="Select cat_id as level1_id from tbl_categories where cat_id='".$level2_parent."' and level='1' ";
				$level1_arr    = $db->get_row($level1_qry,ARRAY_A);
				$cat_level1     = $level1_arr['level1_id'];
				
				$update_qry ="UPDATE tbl_reviews SET cat_level1='".$cat_level1."',cat_level2='".$cat_level2."' where cat_level3='".$update_id."' ";
				$db->query($update_qry);
			}
			elseif($level==2)
			{
				
				
			  $level1_qry ="Select cat_id as level1_id from tbl_categories where cat_id='".$parent_id."' and level='1' ";
			$level1_arr    = $db->get_row($level1_qry,ARRAY_A);
			$cat_level1     = $level1_arr['level1_id'];
			
			$update_qry ="UPDATE tbl_reviews SET cat_level1='".$cat_level1."' where cat_level2='".$update_id."' ";
			$db->query($update_qry);
			}
			
		}
		
		if($_FILES["image_name"]['name']!="")
		{
			$select_img ="select image_name from tbl_categories where cat_id='".$last_record."' ";
			$result = $db->get_row($select_img, ARRAY_A);
			$old_image  = $result['image_name'];
			$imgfile =$path.$old_image;
			$thumbfile =$path.'thumb_'.$old_image;
			$thumbfile_small =$path.'small_thumb_'.$old_image;
			@unlink($imgfile);
			@unlink($thumbfile);
			@unlink($thumbfile_small);
			
			$icon_array = $_FILES["image_name"]['name'];
			$img_formats = array("jpeg", "gif", "png", "jpg","JPEG", "GIF", "PNG", "JPG");
			$allowed_size = 2; // Allowed Photo Size in MB			
			$file_temp = $_FILES["image_name"]['tmp_name'];
			$h_image_size = filesize($_FILES["image_name"]['tmp_name']);
			$h_image_size = ($h_image_size/1024)/1024;
			$h_file_name_array 	= $_FILES["user_image"];
			$h_file_ext = ltrim(strtolower(strrchr($_FILES["image_name"]['name'],'.')),'.'); 
			
			$icon_orgname = rand()."_".$_FILES["image_name"]['name'];
			$h_newthumb_name = 'thumb_'.$icon_orgname;	
			$h_small_thumb_name = 'small_thumb_'.$icon_orgname;			
			$h_photo_path = $path.$icon_orgname;
			$h_photothumb_path = $path.$h_newthumb_name;
			$h_dir = $path;
			
			if($h_image_size < $allowed_size)
			{
				copy($file_temp,$h_photo_path);	
				$a = new Thumbnail($_FILES["image_name"]['tmp_name'],241,'238',$h_dir.$h_newthumb_name);
				// creating thumbnail
				$a->create();
				
				$b = new Thumbnail($_FILES["image_name"]['tmp_name'],97,'97',$h_dir.$h_small_thumb_name);
				// creating thumbnail
				$b->create();
				
				$img_qry="UPDATE tbl_categories SET image_name='".$icon_orgname."' where cat_id='".$last_record."' ";
				$db->query($img_qry);
			}
		}
		echo 'done';
	}
	else
	{
		echo $errorstr;
	}
}
?>
