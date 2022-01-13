 <html>

 <head>
     <!--<link rel="stylesheet" type="text/css" href="css/form.css">-->
     <!-- <link rel="stylesheet" href="css/star-rating.css" media="all" type="text/css"/>-->
     <style>
         .desktop_width {
             width: 50%;
         }

         @media(max-width:768px) {
             .desktop_width {
                 width: 70%;
             }
         }
     </style>
 </head>

 <body>


     <?php if ($mobile_view == 1) {?>
     <div class="modal-dialog modal-lg" style="width:95%;  margin-top:20%; background-color:#FFFFFF;">
         <?php } elseif ($mobile_view == 0) {?>
         <div class="modal-dialog modal-lg desktop_width" style="margin-top:10%;  background-color:#FFFFFF;">
             <?php }?>
             <div class="modal-content">
                 <div class="modal-header" style="padding:0; border-bottom:none; min-height:0;"></div>
             </div>

             <div class="modal-body" style="overflow-y:auto; min-height:250px;">
                 <img onClick="close_review_popup();" data-dismiss="modal"
                     src="<?php echo SERVER_ROOTPATH;?>images/crosspng.png"
                     style="float:right; cursor:pointer; margin-top:10px; margin-right:10px;">
                 <h4 style="font-size:20px; font-weight:normal; margin-bottom:20px;">Thank you</h4>
                 <p>Would you like to delete your post? <br /><br /><br /><br />

                 </p>



                 <button id="delete_btn" name="delete_btn"
                     style="margin-top:15px; display:inline; width:40%; float:left; background-color:#D73B3B; border-color:#D73B3B;"
                     onClick="return discussion_delete(<?php echo $_REQUEST['comment_id'];?>, <?php echo $_REQUEST['num'];?>);"
                     class="btn btn-lg btn-primary btn-block" type="button">Delete</button>

                 <span id="delete_btn" name="delete_btn"
                     style="margin-top:15px; display:inline; width:40%; float:right;" data-dismiss="modal"
                     class="btn btn-lg btn-primary" type="button">Cancel</span>



             </div>
             <script src="<?php echo SERVER_ROOTPATH;?>js/jquery-1.10.2.min.js">
             </script>
             <script type="text/javascript">
                 $.noConflict();

                 function discussion_delete(a, b) {

                     detail = $('#discussion_detail').val();
                     var csrf_token = $('meta[name=csrf-token]').attr('content');

                     $.ajax({
                         url: '<?php echo SERVER_ROOTPATH;?>process/delete_comment_process',
                         type: 'post',
                         data: {
                             'id': a,
                             'detail': detail,
                             'num': b,
                             "_token": csrf_token,
                         },
                         success: function(result) {

                             if (result.search('done') != -1) {
                                 $('#delete_comment_' + b).modal('hide');
                                 $('#comment_delete').modal('show');
                                 window.location.reload();

                             }

                             // Do something with the result
                         }
                     });

                 }
             </script>
 </body>

 </html>