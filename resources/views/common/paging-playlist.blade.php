<?php
$targetpage = get_page_name();
$tbl_name = "";        //your table name
// How many adjacent pages should be shown on each side?
$adjacents = 2;

/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/


/* Setup page vars for display. */
if ($page == 0) $page = 1;                    //if no page var is given, default to 1.
$prev = $page - 1;                            //previous page is page - 1
$next = $page + 1;                            //next page is page + 1
$lastpage = ceil($total_pages / $limit); 
        //lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;                        //last page minus 1

/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
$pagination = "";
if ($lastpage > 1) {

    //previous button
    if ($page > 1)
        $pagination .= "<li><a href=\"$targetpage-$prev\">&laquo;</li>"; 

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
    {
        // echo 'wait';die;
        for ($counter = 1; $counter <= $lastpage; $counter++) {
            $link = '';
            $link = $targetpage.'?page='.$counter;
            // $link = $targetpage . '/' . $counter;
            if ($counter == $page)
                $pagination .= "<li><a href=\"#\" class=\"active\">$counter <span class=\"sr-only\">(current)</span></a></li>";
            else

                // $pagination .= "<li><a href=\"$targetpage-$counter\">$counter</li>";
                $pagination .= "<li><a href=\"$link\">$counter</li>";
        }
    } elseif ($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
    {
        //close to beginning; only hide later pages
        if ($page < 1 + ($adjacents * 2)) {
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                if ($counter == $page)
                    $pagination .= "<li><a href=\"#\" class=\"active\">$counter <span class=\"sr-only\">(current)</span></a></li>";
                else
                    $pagination .= "<li><a href=\"$targetpage-$counter\">$counter</li>";
            } 
            $pagination .= "<li><a href=\"$targetpage-$lastpage\">$lastpage</li>";
        }
        //in middle; hide some front and some back
        elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
            
            $pagination .= "<li><a href=\"$targetpage-1\">1</li>";
            $pagination .= "<li><a href=\"$targetpage-2\">2</li>";

            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                if ($counter == $page)
                    $pagination .= "<li><a href=\"#\" class=\"active\">$counter <span class=\"sr-only\">(current)</span></a></li>";
                else
                    $pagination .= "<li><a href=\"$targetpage-$counter\">$counter</li>";
            }

            $pagination .= "<li><a href=\"$targetpage-$lastpage\">$lastpage</li>";
        }
        //close to end; only hide early pages
        else {
            $pagination .= "<li><a href=\"$targetpage-1\">1</li>";
            $pagination .= "<li><a href=\"$targetpage-2\">2</li>";

            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<li><a href=\"#\" class=\"active\">$counter <span class=\"sr-only\">(current)</span></a></li>";
                else
                    $pagination .= "<li><a href=\"$targetpage-$counter\">$counter</li>";
            }
        }
    }
    //next button
    if ($page < $counter - 1)
        $pagination .= "<li><a href=\"$targetpage-$next\">&raquo;</a></li>";
}
?>
<?php echo $pagination; ?>