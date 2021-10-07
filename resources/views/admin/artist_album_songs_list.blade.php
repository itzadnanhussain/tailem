@include("admin.includes.top")
@include("admin.common.security")
<?php
error_reporting(0); 
 
$dec_artist_id = base64_decode($artist_id);

$dec_album_id = base64_decode($album_id);

$albmlist="select tab.album_title, ta.artist_name from tbl_artist_album tab
			inner join tbl_artists ta on ta.id=tab.album_artist_id
			where tab.album_artist_id = '$dec_artist_id' and tab.id = '$dec_album_id'";

			$artist_list_arr	=	\App\Models\Songs::GetRawData($albmlist);
			$album_title = $artist_list_arr[0]->album_title;
			$artist_name = $artist_list_arr[0]->artist_name;
			
			
    //New code			
    if(isset($_REQUEST['song_id']))
	{
		$song_id = base64_decode($_REQUEST['song_id']);
		$artist_id = base64_decode($_REQUEST['artist_id']);
		$album_id = base64_decode($_REQUEST['album_id']);
		//echo "update `tbl_songs_artist_album` SET `deletion`= 0 where `song_id`= $song_id  and `artist_id`= $artist_id and `album_id`= $album_id"; exit;
		mysqli_query($db->dbh, "update `tbl_songs_artist_album` SET `deletion`= 1 where `song_id`= $song_id  and `artist_id`= $artist_id and `album_id`= $album_id");
// header('Location: '.SERVER_ADMIN_PATH.'artist_album_songs_list?artist_id='.$_REQUEST['artist_id'].'&album_id='.$_REQUEST['album_id']);
 	$url = 'admin/artist_album_songs_list?artist_id='.$_REQUEST['artist_id'].'&album_id='.$_REQUEST['album_id'];
	echo '<script>window.location = "' . $url . '";</script>';	
} 
						
?>

<html>
<head>
<title>Artist <?php echo $artist_name;?>Album Listing</title>
  @include("admin.common.header") 
<script language="javascript" type="text/javascript">
// check boxess submit code
function toggleChecked(status)
{
	$(".check-all").each( function() {
		$(this).attr("checked",status);
	})
}

function multiple_action(frm_id) // for changing multiple status or multiple delete 
{
	var conBox = confirm("Are you sure,you want to Perform this Action?");
	if(conBox)
	{
		document.forms[frm_id].submit();
	}
	else
	{
		return false;
	}				  
}
function show_detail(id)
{
	$("#before_details_div_"+id).toggle();
	$("#after_details_div_"+id).toggle();
}

function change_status(song_id, status)
{
	var csrf_token = $('meta[name=csrf-token]').attr('content'); 

	$.ajax({

		   type: "POST",

		   url: JS_ADMIN_SERVER_PATHROOT+'process/song_status',

		   data: {
			   'song_id' : song_id,
			   'status' : status,
			   "_token": csrf_token,
		   },
	

		   beforeSend: function(){
				$("#remove_song_"+song_id).hide();
				 document.getElementById("loader_song_"+song_id).innerHTML = '<img src='+JS_ADMIN_SERVER_PATHROOT+'images/load.gif>';  
		   },
		   success: function(msg){
				document.getElementById("loader_song_"+song_id).innerHTML = '';  
				
				document.getElementById("show_status_"+song_id).innerHTML = msg;  
				
			}

		 });
}

</script>
</head>
<body>

<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
  
    <tr>
        <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
            @include("admin.common.top_right_menu") 
    </tr>
    <tr>
      <td valign="top"><table border="0" width="100%">
            <tr>
              <td width="10">&nbsp;</td>
              <td><!-- End page header -->
                <!-- End pageheader -->
                <!-- Start home -->
                <div class="BodyContainer">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="heading1"><b><?php echo utf8_decode($artist_name);?></b>:  '<?php echo utf8_decode($album_title);?>' songs</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index">Home</a> 
                                &raquo; <a href="artist_list">Artist Listing</a>
                                &raquo; <a>Artist <?php echo utf8_decode($artist_name);?> Album Listing</a></td>
                              </tr>
                              
                              <tr>
                                <td>
                                <table cellpadding="0" cellspacing="0" class="Panel">
                                    <tbody>
                                      <?php if(isset($msg) && $msg!=""){ ?>
                                      <tr>
                                        <td colspan="6">
                                            <table border="0" cellpadding="0" cellspacing="0" class="Message">
                                              <tbody>
											
                                                <tr>
                                                  <td width="20"><?php if($case==1){ ?>
                                                    <img src="images/success_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                    <?php } ?>
                                                    <?php if($case==2){ ?>
                                                    <img src="images/warning_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                    <?php } ?>
                                                    <?php if($case==3){ ?>
                                                    <img src="images/error_icon.png" vspace="5" width="18" height="18" hspace="10">
                                                    <?php } ?>
													</td>
                                                  <td width="100%"><?php echo base64_decode($msg); ?></td>
                                                </tr>
                                              </tbody>
                                            </table>
										</td>
                                      </tr>
                                      <?php } ?>
                                      
									  <!--<tr>
										  <td colspan="6" width="105" align="right" valign="middle" id="addsymbol" >
											<a href="<?php echo SERVER_ADMIN_PATH; ?>addedit_artist_album?artist_id=<?php echo $_REQUEST['artist_id'];?>"><img src="images/add.png" border="0" title="Add New"></a>
                                          </td>
									  </tr>-->
									  
									  <tr><td colspan="7">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                         <td width="200" id="Heading_list">Image</td>
                                       <td width="300" id="Heading_list">Song</td>
                                       <td width="300" id="Heading_list">Featured In</td>

                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/album_actions" method="post" id="faq_form">
                                      <input type="hidden" name="artist_id" id="artist_id" value="<?php echo $_REQUEST['artist_id'];?>">
									  <?php
									

											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "select tsa.song_id,ts.song_title,ts.picture,tab.album_picture,(select GROUP_CONCAT(ta2.artist_name) as featured_artist from tbl_featured_artist_assocs  as  tfa
			inner join tbl_artists as ta2 on ta2.id=tfa.featured_artist
			where tfa.main_artist=tsa.artist_id and tfa.album_id=tsa.album_id and tfa.song_id=tsa.song_id)  as featured_artist
			
			from tbl_songs_artist_album tsa
			inner join tbl_songs ts on ts.id=tsa.song_id
			inner join tbl_artists ta on ta.id=tsa.artist_id
			inner join tbl_artist_album tab on tsa.album_id=tab.id
			where tsa.artist_id = '$dec_artist_id' and tsa.album_id = '$dec_album_id' and tsa.deletion='0' AND tsa.display_status = 1  group by ts.id ";

										
			$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
			if ($res_count_mypro) {
				$total_pages = count($res_count_mypro);
			} else {
				$total_pages = 0;
			}	

											$targetpage = "artist_album_songs_list?artist_id=$artist_id&album_id=$album_id"; //your file name  (the name of this file)

											


											

											$limit = 20; 					//how many items to show per page

											 

											if($page) 

												$start = ($page - 1) * $limit;//first item to display on this page

											else

												$start = 0;					//if no page var is given, set start to 0

											//PAGGING CODE ENDS HERE	

											//============================================================

											

											if(isset($page) && $page!="")

											{

												$sr_no = ($page*$limit)-$limit;

											}

											else

											{

												$sr_no = 0;

											}

											

											$c=1;
											
										/*$artist_list="select tsa.song_id,ts.song_title,ts.picture,tab.album_picture,(select GROUP_CONCAT(ta2.artist_name) as featured_artist from tbl_featured_artist_assocs  as  tfa
			inner join tbl_artists as ta2 on ta2.id=tfa.featured_artist
			where tfa.main_artist=tsa.artist_id and tfa.album_id=tsa.album_id and tfa.song_id=tsa.song_id)  as featured_artist
			
			from tbl_songs_artist_album tsa
			inner join tbl_songs ts on ts.id=tsa.song_id
			inner join tbl_artists ta on ta.id=tsa.artist_id
			inner join tbl_artist_album tab on tsa.album_id=tab.id
			where tsa.artist_id = '$dec_artist_id' and tsa.album_id = '$dec_album_id' and tsa.deletion='0' LIMIT $start, $limit";*/
			
			//New code
			$artist_list="select ts.song_status, tsa.song_id,tsa.artist_id,tsa.album_id,ts.song_title,ts.picture,tab.album_picture,(select GROUP_CONCAT(ta2.artist_name) as featured_artist from tbl_featured_artist_assocs  as  tfa
			inner join tbl_artists as ta2 on ta2.id=tfa.featured_artist
			where tfa.main_artist=tsa.artist_id and tfa.album_id=tsa.album_id and tfa.song_id=tsa.song_id)  as featured_artist
			
			from tbl_songs_artist_album tsa
			inner join tbl_songs ts on ts.id=tsa.song_id
			inner join tbl_artists ta on ta.id=tsa.artist_id
			inner join tbl_artist_album tab on tsa.album_id=tab.id
			where tsa.artist_id = '$dec_artist_id' and tsa.album_id = '$dec_album_id' and tsa.deletion='0' AND tsa.display_status = 1 group by ts.id LIMIT $start, $limit"; 
			
			$artist_list_arr	=	\App\Models\Songs::GetRawData($artist_list);
										
								 if(isset($artist_list_arr))
									{
									$c=0; $sr_no=0;
										foreach($artist_list_arr as $val)
										{
											$song_id	  = $val['song_id'];

											//New code
											$artist_id	  = $val['artist_id'];
											$album_id	  = $val['album_id'];
											$song_status	= $val['song_status'];
											
											$song_title = stripslashes(html_entity_decode($val['song_title']));
											$song_picture   = stripslashes(html_entity_decode($val['picture']));
											$album_picture = stripslashes(html_entity_decode($val['album_picture']));
											$featured_artist = stripslashes(html_entity_decode($val['featured_artist']));
									
											$status = stripslashes(html_entity_decode($val['status']));
											
											if($c%2==0)
											{
												$bgcolor = "#FEFEE4";
											}
											else
											{
												$bgcolor = "#FFFFFF";	
											}
											
											$c++;
											$sr_no++;
											
									
										 
										 
									?>
								  
								  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $id;?>')" id="row<?php echo $id;?>">
									<td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
									
									<td nowrap="nowrap" class="SmallFieldLabel" width="200">
									<?php
										if($song_picture!="")
										{
										 $findme   = 'http';
										 $pos = strpos($song_picture, $findme);
										 if ($pos === false) 
										{
												$pose = "false";
											
										} else {
											$pose = "true";
										}
										if ($pose == "true")
										{
												$image  =  $song_picture;
											}
											else
											{
												$image  =  "site_upload/song_images/".$song_picture;
											}
											?>
											 <img src="<?php echo $image;?>"  border="0" style="width:70px"/>
											<?php
										}
										elseif($album_picture)
										{
											$findme   = 'http';
										 $pos = strpos($album_picture, $findme);
										 if ($pos === false) 
										{
												$pose = "false";
											
										} else {
											$pose = "true";
										}
										if ($pose == "true")
										{
											$album_picture = $album_picture;
										}
										else
										{
											$album_picture  =  "site_upload/song_images/small_thumb_".$album_picture;
										}
										?>
										<img src="<?php echo $album_picture;?>" width="74" height="71"  border="0"/>
										<?PHP 
										}
										else {
											?>
											 <img src="<?php echo SERVER_ROOTPATH;?>assets/images/no_image4.png"  border="0" width="50" height="50"/>
											<?php
										}
									?>	
										
										
									   
									</td>
									
									<td nowrap="nowrap" class="SmallFieldLabel" width="200">
										<?php echo utf8_decode($song_title);?>
									</td>
									 
								   
									<td nowrap="nowrap" class="SmallFieldLabel" width="70">
									<?php 
									
									$add_feature= '<img src="'.SERVER_ROOTPATH.'Admin-Cp/images/edit.gif" title="Edit Featured In"  border="0" />'; 
									if(empty($featured_artist))
									{
									$add_feature= '<img src="'.SERVER_ROOTPATH.'Admin-Cp/images/add_icon.png"  border="0" title="Add Featured In" />'; 
									}?>
									  <?php echo $featured_artist;?>
                                      &nbsp;&nbsp;
                                      
									 <a href="addedit_featured_artist?song_id=<?php echo base64_encode($song_id); ?>=&artist_id=<?php echo base64_encode($artist_id);?>=&album_id=<?php echo base64_encode($album_id);?>"><?php echo $add_feature; ?></a>
									 &nbsp;&nbsp;
									 
									<!--<a href="artist_album_songs_list?artist_id=<?php echo base64_encode($artist_id);?>&album_id=<?php echo base64_encode($album_id);?>&song_id=<?php echo base64_encode($song_id);?>" ><img src="images/delet.gif" border="0" title="Delete" class="Action"></a>
									&nbsp;&nbsp;-->
									<a href="addedit_song?edit_id=<?php echo base64_encode($song_id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action" /></a>
									&nbsp;&nbsp; 
									<a href="addedit_song?artist_id=<?php echo base64_encode($artist_id);?>&album_id=<?php echo base64_encode($album_id);?>">Add Song</a>
                                    &nbsp;&nbsp; 
                                     <?php
											if($song_status==0)
											{
												//echo '<a href="song_list?status='.base64_encode(1).'&status_id='.base64_encode($id).'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
												echo '<a href="javascript:;" onclick = "change_status('.$song_id.', 1)" id = "remove_song_'.$song_id.'"><img src="images/disable.gif" border="0" class="Action" title="Activate"></a>'; 
											}
											if($song_status==1)
											{
												//echo '<a href="song_list?status='.base64_encode(0).'&status_id='.base64_encode($id).'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
												echo '<a href="javascript:;" onclick = "change_status('.$song_id.', 0)" id = "remove_song_'.$song_id.'"><img src="images/enable.gif" border="0" class="Action" title="Blocked"></a>'; 
											}
										  ?>
                                          <span id="loader_song_<?php echo $song_id;?>"></span>
                                          <span id="show_status_<?php echo $song_id;?>"></span>
                                          
									</td>
									
								  </tr>
								  <?php
										}
									}
										else
										{
									?>
                                      
									  <tr>
                                        <td colspan="6" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                      </tr>
                                      <?php	
										}
									  ?>
									  <tr>
                                        <td colspan="6" align="center" valign="middle"><?php @include("admin.common.cat_details_paging"); ?></td>
                                      </tr>
									  </form>
									  
                                    
                                </table>
                                
                                </td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                          </table></td>
                      </tr>
                  </table>
                </div>
                <!-- End home -->
                <!-- Start pagefooter -->
              </td>
              <td width="10">&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
    </tr>
	
    <tr>
      <td height="20">
		   @include("admin.common.footer")
		</td>
    </tr>
  </tbody>
</table>
<!-- End pagefooter -->
</body>
</html>
