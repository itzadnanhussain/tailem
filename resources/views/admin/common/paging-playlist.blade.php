<style>
/*
Plugin Name: WP-Digg Style Paginator
Plugin URI: http://www.mis-algoritmos.com/2007/09/09/wp-digg-style-pagination-plugin-v-10/
Author: Victor De la Rocha
Author URI: http://www.mis-algoritmos.com
*/

.paging_divs
{
padding-top:20px;
float:left;
}
.pagination {

	padding: 3px;
	margin: 17px 3px 3px 114px;
	
	color:#FFFFFF;
	font-size:12px;
	float:left;

	
}
.nextarrow
{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	font-weight:bold;
	text-align:center;
	color:#FFFFFF;

	
}

.pagination a {
		padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #EEE;
	text-decoration: none; /* no underline */
	color: #036CB4;
	background-color: #FFFFFF;
	font-size:12px;
}

.pagination a:hover,
.pagination a:active {
	border: 1px solid #999;
	color: #666;
 
}
.pagination .current {
	/*padding: 6px 5px 5px 5px;*/
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #036CB4;
	font-weight: bold;
	background-color: #036CB4;
	color: #FFF;
	
}

.number {
	/*padding: 6px 5px 5px 5px;*/
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	text-align:center;
	color:#FFFFFF;
	
	
}

.pagination .disabled {
padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #EEE;
	color: #DDD;
}
</style>

<?php
	/*
		Place code to connect to your DB here.
	*/

	$tbl_name="";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 2;
	// $paramstring = null;
	error_reporting(0);
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	

	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;
	if($total_pages > 0 && $limit > 0)
	{
		$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.

	}	else
	{
		$lastpage = 1;
	}						//next page is page + 1
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	if(isset($serach_postcode) && ($serach_postcode == ""))
	{
		//$paramstring = "";
	}
	
	if(isset($dat_sort) && ($dat_sort == ""))
	{
		//$paramstring = "";
	}
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\"> Page $page of $lastpage 
		<a href=\"$targetpage?page=1\" class=\"nextarrow\">1</a>";
	
		//previous button
		if ($page > 1)
		{
			//if($paramstring != "") { $pagination.= "<a href=\"$targetpage/$prev&$paramstring\" class=\"nextarrow\"><<</a>"; } else { $pagination.= "<a href=\"$targetpage/$prev\" class=\"nextarrow\"> <<</a>"; }
		}
		else
		{
			//$pagination.= "<span class=\"nextarrow\"><<&nbsp;</span>";
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
				{
					$pagination.= "<span class=\"current\">$counter</span>";
				}
				else
				{
					if($paramstring != "") { $pagination.= "<a href=\"$targetpage?page=$counter\" class=\"number\">$counter</a>"; } else {
						$pagination.= "<a href=\"$targetpage?page=$counter\" class=\"number\">$counter</a>";
					}
				}
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
					{
						$pagination.= "<span >$counter</span>";
					}
					else
					{
						if($paramstring != "") { $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>"; } else {
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
						}
					}
				}
				$pagination.= "...";
				if($paramstring != "") { 
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
				}
				else
				{
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>"; 
				}
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				if($paramstring != "") {
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				}
				else
				{
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				}
				
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
					{
						$pagination.= "<span class=\"current\">$counter</span>";
					}
					else
					{
						if($paramstring != "") {
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
						} else {
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
						}
					}
				}
				$pagination.= "...";
				if($paramstring != "") {
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
				} else {
					$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
				}
			}
			//close to end; only hide early pages
			else
			{
				if($paramstring != "") {
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				} else {
					$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
					$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				}
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
					{
						$pagination.= "<span class=\"current\">$counter</span>";
					}
					else
					{
						if($paramstring != "") {
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
						} else {
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
						}
					}
				}
			}
		}
		//next button
		if ($page < $counter - 1)
		{
			if($paramstring != "") {
				//$pagination.= "<a href=\"$targetpage/$next&$paramstring\">&raquo;</a>";
			} else {
				//$pagination.= "<a href=\"$targetpage/$next\" class=\"nextarrow\">>></a>";
			}
		}
		else
		{
			//$pagination.= "<span class=\"nextarrow\">&nbsp;>></span>";
		}
		$pagination.= "<a href=\"$targetpage?page=$lastpage\" class=\"nextarrow\">$lastpage</a></div>\n";		
	}
	//echo "$targetpage/$counter&$paramstring";
?>
<?php echo $pagination?>
