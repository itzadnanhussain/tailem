 <link rel="stylesheet" type="text/css" href="css/form.css">


 <?php //if($mobile_view == 1){
    ?>
 <!--<div class="modal-dialog modal-lg" style="width:95%; margin-top:20%;">-->
 <?php //}elseif($mobile_view == 0){
    ?>
 <!--<div class="modal-dialog modal-lg" style="width:35%; margin-top:10%;">-->
 <?php //}
    ?>


 <style>
     label {
         font-weight: 300;
     }

     body {
         overflow-x: hidden;
     }

     @media (max-width: 430px) {
         .popup_position {
             height: 26px !important;
             margin-top: -9px !important;
             float: right !important;
             padding: 0 !important;
         }
     }
 </style>


 <div class="modal-dialog popup_display">
     <div class="modal-content">
         <div class="modal-header" style="padding:0; border-bottom:none; min-height:0;">
         </div>
         <div class="modal-body" style="padding:0; border:2px solid #000;">

             <img onClick="close_report_popup();" data-dismiss="modal" src="<?php echo SERVER_ROOTPATH; ?>images/crosspng.png" style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">

             <div class="account-wall" style="margin-top:0;">
                 <h4 class="account_hd" style="font-size:20px; font-weight:normal; color:#000000;"> Have an issue with this post? </h4>
                 <!--<img src="images/rline.png"/>-->
                 <br>

                 <form style="padding:10px; padding-top:20px; border-top:1px solid #ccc;" action="<?php echo SERVER_ROOTPATH ?>process/report_process" id="review_report_form" method="POST">
                     @csrf
                     <?php
                        $qry = "select * from tbl_reports_checkbox order by report_chk_box_id asc";
                        $report_list_arr    =    \App\Models\Songs::GetRawData($qry);

                        foreach ($report_list_arr as $row_report) {
                            $row_report = (array)$row_report;
                            $report_chk_box_id    =    stripslashes($row_report['report_chk_box_id']);
                            $report_chk_box_name    =    stripslashes($row_report['report_chk_box_name']);
                        ?>
                         <input style="float:left;width:13px;" class="form-control" name="report_option" id="<?php echo $report_chk_box_id; ?>" value="<?php echo $report_chk_box_id; ?>" type="radio"> &nbsp; <?php echo $report_chk_box_name; ?> <br><br>
                     <?php
                        }
                        ?>

                     <input type="hidden" name="reviewsid" id="reviewsid" value="<?php echo $_REQUEST['rev_id']; ?>" />
                     <input type="hidden" name="num" id="num" value="<?php echo $_REQUEST['num']; ?>" />
                     <textarea id="review_detail" name="review_detail" style="margin-top:20px;" rows="5" type="text" class="form-control" placeholder="Any additional comments?"></textarea>

                     <!-- <button id="submit_btns" name="submit_btns" style="margin-top:10px; display:inline; width:40%;" class="btn btn-lg btn-primary btn-block" type="submit" onclick="validate_report_review_new();">Report Post</button> -->
                     <input type="submit" style="margin-top:10px; display:inline; width:40%;" class="btn btn-lg btn-primary btn-block" value="Report Post">

                     <button id="submit_btns" name="submit_btns" style="margin-top:10px; background-color:#D73B3B; float:right; border-color:#D73B3B; display:inline; width:40%;" class="btn btn-lg btn-primary btn-block" type="submit" data-dismiss="modal">Cancel</button>

                 </form>
             </div>
         </div>
     </div>
 </div>

 <script type="text/javascript">
     function close_report_popup() {
         $(document).on('hidden.bs.modal', function(e) {
             $(e.target).removeData('bs.modal');
             window.location.reload();

         });
     }
 </script>

 <script>
     $('#review_report_form').submit(function(e) {
         e.preventDefault();
         e.stopPropagation();
         let form = $(this).serialize();
         let url = $(this).attr('action');
         $.ajax({
             type: 'POST',
             url: url,
             data: form,
             dataType: 'html',
             success: function(responseText) {

                 //  let responseText = JSON.parse(responseText);
                 myarray = new Array();
                 myarray = responseText.split("-SEPARATOR-");

                 if (responseText.search("done") != -1) {
                     $("#report_Modal4_" + myarray[1]).modal("hide");
                     $("#add_report_request").modal("show");

                     ///redirect to dashboard
                     setTimeout(function() { 
                            window.location.reload();
                        }, 2000)

                 } else {
                     if (responseText.search("Msg") != -1) {
                         myarray1 = new Array();
                         myarray1 = responseText.split("-SEPARATOR-");

                         $("#report_Modal4_" + myarray1[2]).modal("hide");
                         $("#report_success").modal("show");
                     } else if(responseText.search("Please sign in first") != -1) {
                         $("#report_Modal4_1").modal("hide");
                         $("#signin_form").modal("show");
                           ///redirect to dashboard
                     setTimeout(function() { 
                            window.location.reload();
                        }, 5000)

                     }else{
                         alert(responseText);
                     }
                 }

             }
         });

     })



     /* Validate Report*/
     // function validate_report_review_new() {
     //     $("#review_report_form").unbind("submit"); 
     //     var options = {
     //         target: "",
     //         beforeSubmit: null,
     //         success: validate_report_review_new_Response,
     //         type : 'PUT',
     //         url: JS_SERVER_PATHROOT + "process/report_process",

     //     };
     //     $("#review_report_form").submit(function () {
     //         $(this).ajaxSubmit(options);
     //         return false;
     //     });
     // }

     function validate_report_review_new_Response(responseText, statusText) {
         myarray = new Array();
         myarray = responseText.split("-SEPARATOR-");
         if (responseText.search("done") != -1) {
             $("#report_Modal4_" + myarray[1]).modal("hide");
             $("#add_report_request").modal("show");
         } else {
             if (responseText.search("Msg") != -1) {
                 myarray1 = new Array();
                 myarray1 = responseText.split("-SEPARATOR-");

                 $("#report_Modal4_" + myarray1[2]).modal("hide");
                 $("#report_success").modal("show");
             } else {
                 alert(responseText);
             }
         }
     }
 </script>