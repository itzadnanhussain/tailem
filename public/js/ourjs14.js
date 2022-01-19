
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function write_a_review_validation_new() {
    $("#api-readonly").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: write_a_review_validation_Request_new,
        success: write_a_review_validation_Response_new,
        url: JS_SERVER_PATHROOT + "process/write_a_review",
    };
    $("#api-readonly").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
function write_a_review_validation_Request_new(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function write_a_review_validation_Response_new(responseText, statusText) {
    if (responseText.search("done") != -1) {
        $("#show_success_message_song").modal("show");
        window.setTimeout(function () {
            window.location.reload();
        }, 1000);
        //alert(responseText);

        myarray = new Array();
        myarray = responseText.split("-SEPARATOR-");
        $("#api-readonly").each(function () {
            this.reset();
        });
    } else {
        if (responseText == "Please sign in first.") {
            $("#signin_form").modal("show");
        } else if (
            responseText ==
            "You have already posted a review on this song. Please use the EDIT function to revise your review."
        ) {
            $("#already_review").modal("show");
        } else {
            $("#error_popup").modal("show");
            $("#modal_title_error").html("Thank you");
            responseText = responseText.replace(/\n/g, "<br />");
            $("#modal_body_error").html(responseText);
        }
    }
}

/*Edit Username*/

/* Change Password validation is here */
function changeusername_validation() {
    $("#user_name").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: change_username_validation_Request,
        success: change_username_validation_Response,
        url: JS_SERVER_PATHROOT + "process/change_username_process",
    };
    $("#user_name").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
function change_username_validation_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function change_username_validation_Response(responseText, statusText) {
    if (responseText == "done") {
        //window.location.href = JS_SERVER_PATHROOT+"change-usernameword.html";
        $(".error").text("Username updated Successfully!");
        $(".error").show();
        var x = $(".error").position();
        window.scrollTo(x.left, x.top);
        window.setTimeout(function () {
            window.location.href = JS_SERVER_PATHROOT + "review-artist";
        }, 1000);
    } else {
        $(".error").html(responseText);
        $(".error").show();
        var x = $(".error").position();
        window.scrollTo(x.left, x.top);
    }
}








// function write_a_review_validations_new() {
//     $("#api-readonlys").unbind("submit");
//     var options = {
//         target: "",
//         beforeSubmit: validate_reviews_new_Request,
//         success: validate_reviews_new_Response,
//         url: JS_SERVER_PATHROOT + "process/writeareview_process.php",
//     };
//     $("#api-readonlys").submit(function () {
//         $(this).ajaxSubmit(options);
//         return false;
//     });
// }
function validate_reviews_new_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function validate_reviews_new_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        myarray = new Array();
        myarray = responseText.split("-SEPARATOR-");

        $("#edit_Modal4_" + myarray[2]).modal("hide");
        $("#report_edit_success").modal("show");
    } else {
        alert(responseText);
    }
}

/* Discussion validation */
function discussion_validation_new() { 
    // $("#discussion_form").submit(function () {
    //     let form = $(this).serialize(); 
    //     $.ajax({
    //         url: JS_SERVER_PATHROOT + "process/discussion_update_process",
    //         type: 'POST',
    //         data: form,
    //         success:function(responseText)
    //         {
    //             if (responseText.search("done") != -1) {
    //                 myarray = new Array();
    //                 myarray = responseText.split("-SEPARATOR-");
                   
            
    //                 $("#edit_Modal4_" + myarray[1]).modal("hide");
    //                 $("#post_edit_success").modal("show");
    //                 // window.setTimeout(function () {
    //                 //     window.location.reload();
    //                 // }, 1300);
    //             } else {
    //                 alert(responseText);
    //             }
    
    //         }
    //     })
    // });
  
    $("#discussion_form1").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: null,
        success: validate_discussion_new_Response,
        url: JS_SERVER_PATHROOT + "process/discussion_update_process",
    };
    $("#discussion_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}

function validate_discussion_new_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        myarray = new Array();
        myarray = responseText.split("-SEPARATOR-");

        $("#edit_Modal4_" + myarray[1]).modal("hide");
        $("#post_edit_success").modal("show");
        window.setTimeout(function () {
            window.location.reload();
        }, 1300);
    } else {
        alert(responseText);
    }
}

function sign_in_validation_new() {
    $("#user_signin").unbind("submit");
    var a = {
        target: "",
        beforeSubmit: sign_in_validation_Request_new,
        success: sign_in_validation_Response_new,
        url: JS_SERVER_PATHROOT + "process/sign_in_process.php",
    };
    $("#user_signin").submit(function () {
        return $(this).ajaxSubmit(a), !1;
    });
}
function sign_in_validation_Request_new(a, b, c) {
    $.param(a);
    return !0;
}
function sign_in_validation_Response_new(a, b) {
    if (a.search("done") != -1) {
        myarray = new Array();
        myarray = a.split("-SEPARATOR-");
        if (myarray[1] == "reload") {
            window.location.reload();
        } else {
            window.location.href = JS_SERVER_PATHROOT + "review-artist";
        }
    } else {
        $(".error").html(a), $(".error").show();
        var c = $(".error").position();
        window.scrollTo(c.left, c.top);
    }
}

function changepass_validation_new() {
    $("#user_pass").unbind("submit");
    var a = {
        target: "",
        beforeSubmit: change_pass_validation_new_Request,
        success: change_pass_validation_new_Response,
        url: JS_SERVER_PATHROOT + "process/change_pass_process",
    };
    $("#user_pass").submit(function () {
        return $(this).ajaxSubmit(a), !1;
    });
}
function change_pass_validation_new_Request(a, b, c) {
    $.param(a);
    return !0;
}
function change_pass_validation_new_Response(a, b) {
    if ("done" == a) {
        $(".error").text("Password Change Successfully!"), $(".error").show();
        var c = $(".error").position();
        window.scrollTo(c.left, c.top),
            window.setTimeout(function () {
                window.location.href = JS_SERVER_PATHROOT + "review-artist";
            }, 1e3);
    } else {
        $(".error").html(a), $(".error").show();
        var c = $(".error").position();
        window.scrollTo(c.left, c.top);
    }
}

function changeimage_validation_new() {
    $("#profile_pic").unbind("submit");
    var a = {
        target: "",
        beforeSubmit: changeimage_validation_new_Request,
        success: changeimage_validation_new_Response,
        url: JS_SERVER_PATHROOT + "process/change_picture_process",
    };
    $("#profile_pic").submit(function () {
        return $(this).ajaxSubmit(a), !1;
    });
}
function changeimage_validation_new_Request(a, b, c) {
    $.param(a);
    return !0;
}
function changeimage_validation_new_Response(a, b) {
    if ("Done" == a)
        window.location.href = JS_SERVER_PATHROOT + "review-artist";
    else {
        $(".error").html(a), $(".error").show();
        var c = $(".error").position();
        window.scrollTo(c.left, c.top);
    }
}

function close_modal() {
    window.location.reload();
}

function validate_report_discussion_review_new() {
    $("#review_report_form").unbind("submit");
    var a = {
        target: "",
        beforeSubmit: null,
        success: validate_report_discussion_new_review_Response,
        url: JS_SERVER_PATHROOT + "process/report_discussion_process.php",
    };
    $("#review_report_form").submit(function () {
        return $(this).ajaxSubmit(a), !1;
    });
}
function validate_report_discussion_new_review_Response(a, b) {
    myarray = new Array();
    myarray = a.split("-SEPARATOR-");
    if (a.search("done") != -1) {
        $("#edit_Modal4s_" + myarray[1]).modal("hide");
        $("#add_report_request").modal("show");
    } else {
        if (a.search("Msg") != -1) {
            myarray1 = new Array();
            myarray1 = a.split("-SEPARATOR-");

            $("#edit_Modal4s_" + myarray1[2]).modal("hide");
            $("#report_already_message").modal("show");
        } else {
            alert(a);
        }
    }
}

/*discussion report*/
function validate_report_discussion_report_new() {
    $("#review_report_form").unbind("submit");
    var a = {
        target: "",
        beforeSubmit: null,
        success: validate_report_discussion_new_report_Response,
        url: JS_SERVER_PATHROOT + "process/report_discussion_process.php",
    };
    $("#review_report_form").submit(function () {
        return $(this).ajaxSubmit(a), !1;
    });
}
function validate_report_discussion_new_report_Response(a, b) {
    myarray = new Array();
    myarray = a.split("-SEPARATOR-");
    if (a.search("done") != -1) {
        $("#report_Modal4_" + myarray[1]).modal("hide");
        $("#add_report_request").modal("show");
    } else {
        alert(a);
    }
}

function add_in_favourite_user_profile_mainlist_new(a, b, c) {
    var csrf_token = $('meta[name=csrf-token]').attr('content');

    $.ajax({
        url: JS_SERVER_PATHROOT +
            "process/favourite_userprofile_mainlikes?prod_id=" +
            a +
            "&sr_no=" +
            b +
            "&db_user_name=" +
            c,
        data: {
            "_token": csrf_token,
        },
        success: function (a) {
            if (a == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (a == "aa") {
                $("#your_own_profile").modal("show");
            } else {
                $("#myStyle_sub_profile_" + b).html(a);
                $("#myStyle_sub_profile_" + b).show();
                $("#other_dis_sub_profile_" + b).hide();
            }
        }
    });
}

function add_in_favourite_user_profile_screen_new(a, b, c) {
    var csrf_token = $('meta[name=csrf-token]').attr('content');

    $.ajax({
        type: 'post',
        url: JS_SERVER_PATHROOT +
        "process/favourite_userprofile_screenlikes",
        data:{
            'prod_id':a,
            'sr_no':b,
            'db_user_name':c,
            "_token": csrf_token, 
        }, 
       success:function (a) {
            if (a == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (a == "aa") {
                $("#your_own_profile").modal("show");
            } else {
                $("#myStyle_sub_profile_sc_" + b).html(a);
                $("#myStyle_sub_profile_sc_" + b).show();
                $("#other_dis_sub_profile_sc_" + b).hide();
            }
        }
    });
}

function add_in_favourite_main_profile_list_new(a, b, c) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/favourite_userprofile_likes_main_list?prod_id=" +
        a +
        "&sr_no=" +
        b +
        "&username=" +
        c,
        function (a) {
            if (a == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (a == "aa") {
                jQuery.noConflict();
                $("#your_own_profile").modal("show");
                // $("#your_own_profile").css("display", "block");
            } else {
                $("#myStyle_sub_profile_main_" + b).html(a);
                $("#myStyle_sub_profile_main_" + b).show();
                $("#other_dis_sub_profile_main_" + b).hide();
            }
        }
    );
}

/*Like user Review*/
function add_in_favourite_list_review_screen_new(a, b, c, d) {
    var csrf_token = $('meta[name=csrf-token]').attr('content');
    $.ajax({
        type: "POST",
        url: JS_SERVER_PATHROOT +
            "process/favourite_like_review_screen?prod_id=" +
            a +
            "&user_name=" +
            b +
            "&r_fav=" +
            c +
            "&tm=" +
            d,
        data: {
            "_token": csrf_token,
        },
        success: function (b) {
            if (b == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (b.search("You cannot like your own review") != -1) {
                // alert("Record Delete Successfully");
                $("#your_own_review").modal("show");
            } else {
                $("#myStyle_sub_" + a + "_" + d).html(b);
                $("#myStyle_sub_" + a + "_" + d).show();
                $("#other_dis_sub_" + a + "_" + d).hide();
                $("#myStyle_sub_" + a + "_" + d).removeClass(
                    "like-group liked"
                );
            }
        }
    });
}

function add_in_favourite_list_sub(a, b, c) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/favourite_like_sub?prod_id=" +
        a +
        "&artist_seo=" +
        b +
        "&k=" +
        c,
        function (b) {
            if (b == "Please sign in first") {
                $("#signin_form").modal("show");
            } else {
                $("#myStyle_sub_" + a).html(b);
                $("#myStyle_sub_" + a).show();
                $("#other_dis_sub_" + a).hide();
            }
        }
    );
}

function add_in_favourite_user_profile_size(a, b, c) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/add_in_favourite_user_profile_size.php?prod_id=" +
        a +
        "&sr_no=" +
        b +
        "&db_user_name=" +
        c,
        function (a) {
            if (a == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (a == "aa") {
                $("#your_own_profile").modal("show");
            } else {
                $("#myStyle_sub_profile_" + b).html(a);
                $("#myStyle_sub_profile_" + b).show();
                $("#other_dis_sub_profile_" + b).hide();
            }
        }
    );
}

function add_in_favourite_user_profile_size(a, b, c) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/add_in_favourite_user_profile_size.php?prod_id=" +
        a +
        "&sr_no=" +
        b +
        "&db_user_name=" +
        c,
        function (a) {
            if (a == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (a == "aa") {
                $("#your_own_profile").modal("show");
            } else {
                $("#myStyle_sub_profile_" + b).html(a);
                $("#myStyle_sub_profile_" + b).show();
                $("#other_dis_sub_profile_" + b).hide();
            }
        }
    );
}

function add_in_favourite_user_profile_mainlist_discussion_new(a, b, c) {
    var csrf_token = $('meta[name=csrf-token]').attr('content');
    $.ajax({
        url: JS_SERVER_PATHROOT +
            "process/favourite_userprofile_likes_discussion",
        type: 'POST',
        data: {
            'prod_id': a,
            'sr_no': b,
            'db_user_name': c,
            "_token": csrf_token, 
        }, 
        success: function (a) {
            if (a == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (a == "aa") {
                $("#your_own_profile").modal("show");
            } else {
                $("#myStyle_sub_profile_discussion_" + b).html(a);
                $("#myStyle_sub_profile_discussion_" + b).show();
                $("#other_dis_sub_profile_discussion_" + b).hide();
            }
        }
    });
}

function add_in_favourite_list_review_song(a, b, c) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/favourite_like_review_song?prod_id=" +
        a +
        "&user_name=" +
        b +
        "&r_fav=" +
        c,
        function (b) {
            if (b == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (b.search("You cannot like your own review") != -1) {
                $("#your_own_review").modal("show");
            } else {
                $("#myStyle_sub_" + a).html(b);
                $("#myStyle_sub_" + a).show();
                $("#other_dis_sub_" + a).hide();
                /*$("#myStyle_sub_"+a).removeClass("like-group liked");
        $("#myStyle_sub_"+a).addClass("like-group");*/
            }
        }
    );
}

function add_in_favourite_list_review_song_second(a, b, c) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/favourite_like_review_song_second.php?prod_id=" +
        a +
        "&user_name=" +
        b +
        "&r_fav=" +
        c,
        function (b) {
            if (b == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (b.search("You cannot like your own review") != -1) {
                $("#your_own_review").modal("show");
            } else {
                $("#myStyle_sub_" + a).html(b);
                $("#myStyle_sub_" + a).show();
                $("#other_dis_sub_" + a).hide();
            }
        }
    );
}

// function add_in_favourite_list_review_song_detail(a, b, c) {
//     $.post(
//         JS_SERVER_PATHROOT +
//             "process/favourite_like_review_song_like_detail?prod_id=" +
//             a +
//             "&user_name=" +
//             b +
//             "&r_fav=" +
//             c,
//         function (b) {
//             if (b == "Please sign in first") {
//                 $("#signin_form").modal("show");
//             } else if (b.search("You cannot like your own review") != -1) {
//                 $("#your_own_review").modal("show");
//             } else {
//                 $("#myStyle_sub_" + a).html(b);
//                 $("#myStyle_sub_" + a).show();
//                 $("#other_dis_sub_" + a).hide();
//                 /*$("#myStyle_sub_"+a).removeClass("like-group liked");
// 		$("#myStyle_sub_"+a).addClass("like-group");*/
//             }
//         }
//     );
// }

function add_in_favourite_user_profile_mob(a, b, c) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/favourite_userprofile_moblikes.php?prod_id=" +
        a +
        "&sr_no=" +
        b +
        "&db_user_name=" +
        c,
        function (a) {
            if (a == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (a.search("You cannot like your own profile") != -1) {
                $("#your_own_profile").modal("show");
            } else {
                $("#myStyle_sub_profile_mb_" + b).html(a);
                $("#myStyle_sub_profile_mb_" + b).show();
                $("#other_dis_sub_profile_mb_" + b).hide();
            }
        }
    );
}

function add_in_favourite_list_review_mob(a, b, c) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/favourite_like_review_mob.php?prod_id=" +
        a +
        "&user_name=" +
        b +
        "&r_fav=" +
        c,
        function (b) {
            if (b == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (b.search("You cannot like your own review") != -1) {
                $("#your_own_review").modal("show");
            } else {
                $("#myStyle_sub_mob_" + a).html(b);
                $("#myStyle_sub_mob_" + a).show();
                $("#other_dis_sub_mob_" + a).hide();
                $("#myStyle_sub_mob_" + a).removeClass("like-group liked");
            }
        }
    );
}

// function review_delete_new(a, b) {
//     if ("" != a) {
//         $.post(
//             JS_SERVER_PATHROOT +
//                 "process/delete_review_process?reviewid=" +
//                 a,
//             function (a) {
//                 if (a == "Please sign in first") {
//                     $("#signin_form").modal("show");
//                 } else {
//                     if (a.search("done") != -1) {
//                         $("#delete_review_" + b).hide();
//                         $("#review_delete").modal("show");
//                     } else {
//                         alert(a);
//                     }
//                 }
//             }
//         );
//     }
// }

function newpass_validation_new() {
    $("#user_pass").unbind("submit");
    var a = {
        target: "",
        beforeSubmit: newpass_validation_Request,
        success: newpass_validation_Response,
        url: JS_SERVER_PATHROOT + "process/newpass_process.php",
    };
    $("#user_pass").submit(function () {
        return $(this).ajaxSubmit(a), !1;
    });
}
function newpass_validation_Request(a, b, c) {
    $.param(a);
    return !0;
}
function newpass_validation_Response(a, b) {
    if (a == "done") {
        $("#reset_password").modal("show");
        $("#user_pass").each(function () {
            this.reset();
        });
    } else {
        $("#error_popup").modal("show");
        $("#modal_title_error").html("Thank you");
        a = a.replace(/\n/g, "<br />");
        $("#modal_body_error").html(a);
    }
}

function add_in_favourite_list_sub_artist_new(a, b, c, d) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/favourite_like_sub_artist2?prod_id=" +
        a +
        "&sr_no=" +
        b +
        "&artist_seo=" +
        c +
        "&k=" +
        d,
        function (c) {
            if (c == "Please sign in first") {
                $("#signin_form").modal("show");
            } else {
                $("#myStyle_sub_" + b + "_" + a).html(c);
                $("#myStyle_sub_" + b + "_" + a).show();
                $("#other_dis_sub_" + b + "_" + a).hide();
            }
        }
    );
}

function add_in_playlist(a) {
    var csrf_token = $('meta[name=csrf-token]').attr('content');
    $.ajax({
        type: 'POST',
        url: JS_SERVER_PATHROOT + "process/favourite_playlist?prod_id=" + a,
        data: {
            "_token": csrf_token,
        },
        success: function (c) {
            if (c == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (c == "aa") {
                $("#error_popup").modal("show");
                $("#modal_title_error").html("Thank you");
                responseText = c.replace(/\n/g, "<br />");
                $("#modal_body_error").html(
                    "Unfortunately, you cannot like your own playlist."
                );
                $("#modal_body_error").show();
            } else {
                $("#myStyle_profile_" + a).html(c);
                $("#myStyle_profile_" + a).show();

                $("#other_dis_sub_" + a).hide();
                $("#show_playlist_likes_" + a).hide();
            }
        }
    });
}

$(document).ready(function () {
    $("#delete_playlist").on("hide.bs.modal", function () {
        $("#delete_playlist").removeData("bs.modal");
        $("#delete_playlist").find(".modal-content").html("");
        $(".modal-backdrop").remove();
    });

    $("#show_playlist").on("hide.bs.modal", function () {
        $("#show_playlist").removeData("bs.modal");
        $("#show_playlist").find(".modal-content").html("");
        $(".modal-backdrop").remove();
    });

    $("#artist_modal").on("hide.bs.modal", function () {
        $("#artist_modal").removeData("bs.modal");
        $("#artist_modal").find(".modal-content").html("");
        $(".modal-backdrop").remove();
    });

    $("#missing_popular_review_Modal2_5000").on("hide.bs.modal", function () {
        $("#missing_popular_review_Modal2_5000").removeData("bs.modal");
        $("#missing_popular_review_Modal2_5000")
            .find(".modal-content")
            .html("");
        $(".modal-backdrop").remove();
    });

    $("#review_modal").on("hide.bs.modal", function () {
        $("#review_modal").removeData("bs.modal");
        $("#review_modal").find(".modal-content").html("");
        $(".modal-backdrop").remove();
    });

    $("#profile_modal").on("hide.bs.modal", function () {
        $("#profile_modal").removeData("bs.modal");
        $("#profile_modal").find(".modal-content").html("");
        $(".modal-backdrop").remove();
    });

    $("#profile_Modal2_99999999").on("hide.bs.modal", function () {
        $("#profile_Modal2_99999999").removeData("bs.modal");
        $("#profile_Modal2_99999999").find(".modal-content").html("");
        $(".modal-backdrop").remove();
    });
});

function replaceStr(str, find, replace) {
    for (var i = 0; i < find.length; i++) {
        str = str.replace(new RegExp(find[i], "gi"), replace[i]);
    }
    return str;
}



var myVar;

function myStopFunction() {
    clearTimeout(myVar);
}


///playlist_delete
function playlist_delete(a, p) {
    var csrf_token = $('meta[name=csrf-token]').attr('content');
    $.ajax({
        url: JS_SERVER_PATHROOT + 'process/delete_playlist_process?id=' + a + "&p=" + p,
        type: 'post',
        data: {
            "_token": csrf_token,
        },
        success: function (result) {

            if (result.search('done') != -1) {
                myarray = new Array();
                myarray = result.split('-SEPARATOR-');


                $('#delete_playlist').modal('hide');
                window.location.href = myarray[1];

            } else {
                alert(result);
            }

            // Do something with the result
        }
    });

}

/*ADD list of songs in playlist*/

function add_songto_playlist_validations_new() {
    $("#add_to_playlist").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_songto_playlist_new_Request,
        success: validate_songto_playlist_new_Response,
        url: JS_SERVER_PATHROOT + "process/add_songto_playlist_process",
    };
    $("#add_to_playlist").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
function validate_songto_playlist_new_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function validate_songto_playlist_new_Response(responseText, statusText) {
    myStopFunction(myVar);
    if (responseText.search("done") != -1) {
        myarray = new Array();
        myarray = responseText.split("-SEPARATOR-");

        $("#error_list").hide();
        $("#success_list").html(myarray[1]);
        $("#success_list").show();
        myVar = setTimeout(function () {
            $("#success_list").fadeOut();
        }, 5000);
    } else {
        $("#success_list").hide();
        $("#error_list").html(responseText);
        $("#error_list").show();

        myVar = setTimeout(function () {
            $("#error_list").fadeOut();
        }, 5000);
    }
}

function update_playlist_validations_new() {
    $("#add_playlist").unbind("submit");
    var csrf_token = $('meta[name=csrf-token]').attr('content');

    var options = {
        target: "",
        data: {
            "_token": csrf_token,
        },
        beforeSubmit: validate_update_playlist_new_Request,
        success: validate_update_playlist_new_Response,
        url: JS_SERVER_PATHROOT + "process/update_playlist_process",
    };
    $("#add_playlist").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}

function validate_update_playlist_new_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function validate_update_playlist_new_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        $("#create_playlist").modal("hide");
        $("#playlist_update").modal("show");

        myarray = new Array();
        myarray = responseText.split("-SEPARATOR-");

        window.location.href = myarray[1];
    } else {
        $("#error_list").html(responseText);
        $("#error_list").show();
        $("#error_list").fadeOut(10000);
    }
}

function show_detail_artist(pass) {
    if (pass == "more") {
        $("#show_more_info").show();
        $("#show_less_info").hide();
    } else if (pass == "less") {
        $("#show_more_info").hide();
        $("#show_less_info").show();
    }
}

function add_in_favourite_like_profile_new(a, b, c) {
    var csrf_token = $('meta[name=csrf-token]').attr('content');

    $.ajax({
        type: 'POST',
        url: JS_SERVER_PATHROOT +
            "process/favourite_userprofile_likes_page?prod_id=" +
            a +
            "&sr_no=" +
            b +
            "&username=" +
            c,
        data: {
            "_token": csrf_token,
        },

        success: function (a) {
            if (a == "Please sign in first") {
                $("#signin_form").modal("show");
            } else if (a == "aa") {
                $("#your_own_profile").modal("show");
            } else {
                $("#myStyle_sub_profile_main_" + b).html(a);
                $("#myStyle_sub_profile_main_" + b).show();
                $("#other_dis_sub_profile_main_" + b).hide();
            }
        }
    });
}

function add_in_favourite_list_sub_artist_mob_new(a, b, c, d) {
    $.post(
        JS_SERVER_PATHROOT +
        "process/favourite_like_sub_artist_mob.php?prod_id=" +
        a +
        "&sr_no=" +
        b +
        "&artist_seo=" +
        c +
        "&k=" +
        d,
        function (c) {
            if (c == "Please sign in first") {
                $("#signin_form").modal("show");
            } else {
                $("#myStyle_sub_mob_" + b + "_" + a).html(c);
                $("#myStyle_sub_mob_" + b + "_" + a).show();
                $("#other_dis_sub_mob_" + b + "_" + a).hide();
            }
        }
    );
}
