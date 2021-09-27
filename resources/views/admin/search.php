<?php include("includes/top.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
<link rel="stylesheet" type="text/css" href="http://58.65.172.229:808/tailem/Admin-Cp/styles/jquery.tokenize.css" />
</head>
<body>

			 <select id="artist" style="width: 80%; height: 120px; overflow-y: scroll;" multiple="multiple" onkeyup="" class="tokenize-sample" name="artist[]">
						 <?php							
							$artist_list="select id, artist_name from tbl_artists where artist_status = 1 LIMIT 0,100";
							$artist_list_arr	=	$db->get_results($artist_list,ARRAY_A);
							
									foreach($artist_list_arr as $get_info)
											{
												
												$id =  $get_info['id'];
												$name = $get_info['artist_name'];
												echo '<option value="'.$id.'">'.$name.'</option>';
											}
									
										?>
                                        </select>
                                         <div id="jump_div"></div>
                         
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://58.65.172.229:808/tailem/Admin-Cp/js/jquery.form.js" language="javascript"></script>
<script type="text/javascript" src="http://58.65.172.229:808/tailem/Admin-Cp/js/jquery.tokenize.js"></script>
<script type="text/javascript">
    $('#artist').tokenize({
      searchMaxLength:30
    });
    </script>
</body>
</html>
