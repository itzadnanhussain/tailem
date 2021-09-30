<table style="border-collapse: collapse;" border="0" cellpadding="0" width="100%">
  <tbody>
    <tr>
       <td width="30%" valign="top" style="padding-top:0px; padding-left:20px;">
	  		<div class="top_page_title" align="left">
			<font style="color:#FFFFFF;" onmouseover="this.style.cursor='pointer'" onclick="window.location='<?php echo SERVER_ADMIN_PATH;?>index'"><?php echo PAGE_TITLE;?></font>
		</div>
	  </td>
      <td class="textlinks" align="right" width="70%" style="padding-top:10px;"><span class="MenuText">
       		<a href="index" class="MenuText">Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<span class="MenuText">
		   		<span class="MenuText"></span>
				<span class="MenuText"><a href="<?php echo SERVER_ADMIN_PATH;?>setting" class="MenuText">Setting</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<span class="MenuText"><a href="<?php echo SERVER_ADMIN_PATH;?>logout" class="MenuText">Logout</a>
        <div style="padding-top: 3px;" class="top"> 
        	You are currently logged in as: 
            <span class="username_span"><?php echo session()->get("reviewsite_cpadmin_uname");?> </span>
        </div>
        </span></span></span></span></span></span></span></span></span> </span> </td>
    </tr>
    <tr>
      <td colspan="2" style="padding-left:20px; padding-bottom:1px;" valign="bottom" width="100%" height="30">
      @include("admin.common.topmenu")
      </td>
    </tr>
  </tbody>
</table>