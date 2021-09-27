<?php
include("../includes/top.php");
error_reporting(0);
if(isset($_FILES)) 
{
	$errorstr="";
	$case = 1;
	$image1 = $_FILES['itune_img']['name']; 
	$image2 = $_FILES['amazon_img']['name'];
	$image3 = $_FILES['google_img']['name'];
				
	$path			= '../../site_upload/artist_images/';
	$update_id = $_REQUEST['update_id'];
	
	
	if($case==1)
	{
		if($update_id != '')
		{

		if($image1 != ''){
					$allowedExts = array("gif", "jpeg", "jpg", "png","GIF", "JPEG", "JPG", "PNG");
					$temp = explode(".", $_FILES['itune_img']['name']);
					$extension = end($temp);

						if (!in_array($extension, $allowedExts))
						{	
						echo "You have selected an invalid file\n"."Valid files are gif, png, jpg, jpeg\n";
						$case = 0;
						exit;	
						}
						if($_FILES['itune_img']['size'] > 5000000)
						{
						echo "Selected image too large\n"."Max size allowed is 5MB\n";
						$case = 0;
						exit;	
						}	
						else{
						$new_file_name= rand().'_'.$_FILES['itune_img']['name'];
						move_uploaded_file($_FILES['itune_img']['tmp_name'],"../../site_upload/artist_images/".$new_file_name);
						$case = 1;
						$db->query("update tbl_store_img set store_img='".$new_file_name."'where store_id='".$update_id."'");
											
						}
									
				}
		if($image2 != ''){
					$allowedExts = array("gif", "jpeg", "jpg", "png","GIF", "JPEG", "JPG", "PNG");
					$temp = explode(".", $_FILES['amazon_img']['name']);
					$extension = end($temp);

						if (!in_array($extension, $allowedExts))
						{	
						echo "You have selected an invalid file\n"."Valid files are gif, png, jpg, jpeg\n";
						$case = 0;
						exit;	
						}
						if($_FILES['amazon_img']['size'] > 5000000)
						{
						echo "Selected image too large\n"."Max size allowed is 5MB\n";
						$case = 0;
						exit;	
						}	
						else{
						$new_file_name= rand().'_'.$_FILES['amazon_img']['name'];
						move_uploaded_file($_FILES['amazon_img']['tmp_name'],"../../site_upload/artist_images/".$new_file_name);
						$case = 1;
						$db->query("update tbl_store_img set store_img='".$new_file_name."'where store_id='".$update_id."'");
											
						}
									
				}
		if($image3 != ''){
					$allowedExts = array("gif", "jpeg", "jpg", "png","GIF", "JPEG", "JPG", "PNG");
					$temp = explode(".", $_FILES['google_img']['name']);
					$extension = end($temp);

						if (!in_array($extension, $allowedExts))
						{	
						echo "You have selected an invalid file\n"."Valid files are gif, png, jpg, jpeg\n";
						$case = 0;
						exit;	
						}
						if($_FILES['google_img']['size'] > 5000000)
						{
						echo "Selected image too large\n"."Max size allowed is 5MB\n";
						$case = 0;
						exit;	
						}	
						else{
						$new_file_name= rand().'_'.$_FILES['itune_img']['name'];
						move_uploaded_file($_FILES['google_img']['tmp_name'],"../../site_upload/artist_images/".$new_file_name);
						$case = 1;
						$db->query("update tbl_store_img set store_img='".$new_file_name."'where store_id='".$update_id."'");
											
						}
									
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