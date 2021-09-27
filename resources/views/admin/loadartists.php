<?php
						include("../db.php");
						$srch_search_sess=$_GET['search'];
						
						$artist_list="select id, artist_name from tbl_artists where artist_status = 1 and  artist_name like '$srch_search_sess%' order by '$srch_search_sess' limit 0,100";	
						
						
						
					
						
						//100000
							$admin_artist_list = mysqli_query($con, $artist_list);
							$data_results=array();
							$i=0;
							while ($val = mysqli_fetch_array($admin_artist_list)){
								 $data_results[$i]['value']=$val['id'];
								  $data_results[$i]['text']= stripslashes(html_entity_decode($val['artist_name']));
								$i++;  
							}
							
							
						echo json_encode($data_results);


?>