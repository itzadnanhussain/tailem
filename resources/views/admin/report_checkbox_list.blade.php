@include("admin.includes.top")
@include("admin.common.security")
<?php
error_reporting(0); 
 
//---------- Ordering ----------//
switch($sortby)
{
	case "name_desc":
		$orderby	= " ORDER BY report_chk_box_name desc";
	break;
	
	case "name_asc":
		$orderby	= " ORDER BY report_chk_box_name asc";
	break;

	
	default:
		$orderby = "ORDER BY report_chk_box_id asc";
	break;
}
?>
<html>
<head>
<title>Report Option Listing</title>
 @include("admin.common.header") 
</head>
<body>

<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%" height="100%">
  
    <tr>
        <td style="background:#1F3C5C; background-repeat:repeat-x; height:60px;" height="60">
          @include("admin.common.top_right_menu") 
        </td>
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
                        <td class="heading1">Report Option Listing</td>
                      </tr>
                      <tr>
                        <td class="body"><table id="Table1" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td><a href="<?php echo SERVER_ADMIN_PATH;?>index">Home</a> &raquo; <a>Report Option Listing</a></td>
                              </tr>
                              
                              <tr>
                                <td>
                                <table cellpadding="0" cellspacing="0" class="Panel">
                                    <tbody>
                                      
									 
									  <tr><td colspan="7">&nbsp;</td></tr>
                                      <tr>
                                        <td width="30" id="Heading_list">Sr #</td>
                                        <td width="300" id="Heading_list">
                                        <?php if($sortby == 'name_desc'){?>
                                        <a href="report_checkbox_list?sortby=name_asc&page=<?php echo $page;?>" class="link_class">Report Option Name</a>
                                        <?php }else{?>
                                        <a href="report_checkbox_list?sortby=name_desc&page=<?php echo $page;?>" class="link_class">Report Option Name</a>
                                        <?php }?>
                                        </td>
                                        
                                        <td width="70" id="Heading_list" class="righttd_border"> Action</td>
                                      </tr>
                                      
									  <form action="<?php echo SERVER_ADMIN_PATH; ?>process/faq_actions" method="post" id="faq_form">
									  <?php
											
											//============================================================
											//PAGGING CODE STARTS HERE
											$qry_count_mypro = "SELECT report_chk_box_id FROM tbl_reports_checkbox where 1=1
											$session_where  $orderby";
											
											$res_count_mypro = array();
											$res_count_mypro = \App\Models\Songs::GetRawData($qry_count_mypro);
											if ($res_count_mypro) {
												$total_pages = count($res_count_mypro);
											} else {
												$total_pages = 0;
											}		
											$targetpage = "report_checkbox_list"; //your file name  (the name of this file)
											
											
											$limit = 15; 					//how many items to show per page
										 
											
											if($page) 
												$start = ($page - 1) * $limit;//first item to display on this page
											else
												$start = 0;	
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

										$report_option_list="select * from tbl_reports_checkbox where 1=1 $orderby 
										LIMIT $start, $limit";	
											
										$report_option_list_arr	=	\App\Models\Songs::GetRawData($report_option_list);
										
										if(isset($report_option_list_arr) && !empty($report_option_list_arr))
										{
											foreach($report_option_list_arr as $val)
											{
												$val = (array)$val;
												$report_chk_box_id	  = $val['report_chk_box_id'];	
												$report_chk_box_name = stripslashes(html_entity_decode($val['report_chk_box_name']));
												$report_chk_box_name = wordwrap($report_chk_box_name,100," ",true);
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
									  
									  <tr bgcolor="<?php echo $bgcolor; ?>" onMouseOver="changebackcolor_hover('row<?php echo $report_chk_box_id;?>')" onMouseOut="changebackcolor_blur('row<?php echo $report_chk_box_id;?>')" id="row<?php echo $report_chk_box_id;?>">
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="30"><?php echo $sr_no;?></td>
                                        <td nowrap="nowrap" class="SmallFieldLabel" width="300">
											<?php echo $report_chk_box_name;?>
                                        </td>
                                        
                                        
                                        <td nowrap="nowrap" class="SmallFieldLabel righttd_border" width="70"> 
										&nbsp;&nbsp;
                                        <?php
										if($top_reviews_module_add=="Yes")
										{
										?>	
                                        <a href="add_report_checkbox?edit_id=<?php echo base64_encode($report_chk_box_id);?>"><img src="images/edit.gif" border="0" title="Edit" class="Action"></a>
                                        <?php
										}
										?>
										<?php
										if($top_reviews_module_delete=="Yes")
										{
										?>
                                        &nbsp; &nbsp;
                                        <a href="javascript:;" onClick="delete_report_option('<?php echo $report_chk_box_id;?>')"><img src="images/delet.gif" border="0" title="Delete Report" class="Action" ></a>
                                        <?php
										}
										?>
                                        </td>
                                      </tr>
                                      <?php
											}
										}
										else
										{
									?>
                                      
									  <tr>
                                        <td colspan="3" align="center" nowrap="nowrap" class="SmallFieldLabel righttd_border" style="font-weight:bold; color:#FF0000;"> NO RECORD FOUND!</td>
                                      </tr>
                                      <?php	
										}
									  ?>
									  <tr>
                                        <td colspan="3" align="center" valign="middle"><?php @include("admin.common.paging-playlist"); ?></td>
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
