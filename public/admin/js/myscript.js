function changebackcolor_hover(did) {
    document.getElementById(did).style.backgroundColor = "#FEFE9B";
}

function changebackcolor_blur(did) {
    document.getElementById(did).style.backgroundColor = "";
}

//----------------------------------------------------//
function isInteger(s) {
    var i;

    s = s.toString();

    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);

        if (isNaN(c)) {
            alert("Given value is not a number");

            return false;
        }
    }

    return true;
}

//-------------------------------------------------------------------------------

//INTEGER VALIDATION

function keynumber(evt) {
    evt = evt ? evt : window.event;

    var charCode = evt.which ? evt.which : evt.keyCode;

    if (
        (charCode > 45 && charCode < 59) ||
        charCode == 32 ||
        charCode == 8 ||
        charCode == 9 ||
        charCode == 13 ||
        charCode == 127
    ) {
        return true;
    } else {
        alert("This Field accepts Only Number");

        return false;
    }
}

//-------------------------------------------------------------------------------

//URL Validation

function is_valid_url(url) {
    return url.match(
        /^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/
    );
}

//-------------------------------------------------------------------------------

//email validation function

function echeck(str) {
    var at = "@";

    var dot = ".";

    var lat = str.indexOf(at);

    var lstr = str.length;

    var ldot = str.indexOf(dot);

    if (str.indexOf(at) == -1) {
        alert("Invalid E-mail ID");

        return false;
    }

    if (
        str.indexOf(at) == -1 ||
        str.indexOf(at) == 0 ||
        str.indexOf(at) == lstr
    ) {
        alert("Invalid E-mail ID");

        return false;
    }

    if (
        str.indexOf(dot) == -1 ||
        str.indexOf(dot) == 0 ||
        str.indexOf(dot) == lstr
    ) {
        alert("Invalid E-mail ID");

        return false;
    }

    if (str.indexOf(at, lat + 1) != -1) {
        alert("Invalid E-mail ID");

        return false;
    }

    if (
        str.substring(lat - 1, lat) == dot ||
        str.substring(lat + 1, lat + 2) == dot
    ) {
        alert("Invalid E-mail ID");

        return false;
    }

    if (str.indexOf(dot, lat + 2) == -1) {
        alert("Invalid E-mail ID");

        return false;
    }

    if (str.indexOf(" ") != -1) {
        alert("Invalid E-mail ID");

        return false;
    }

    return true;
}

//-------------------------------------------------------------------------------

function clearstring(checkStr) {
    allvalid = /[^A-Za-z\d ]/.test(checkStr) == false;

    if (allvalid == false) {
        alert("Please enter alphanumeric values");

        return false;
    }

    if (allvalid == true) {
        return true;
    }
}

/*===================Validate Social Link====================*/

function validate_social_links() {
    $("#social_link_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_social_links_Request,

        success: validate_social_links_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/social_link_process",
    };

    // bind to the form's submit event

    $("#social_link_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_social_links_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_social_links_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "social_links";
    } else {
        alert(responseText);
    }
}

/*===================Validate Admin Email ====================*/

function validate_email() {
    $("#email_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_email_Request,

        success: validate_email_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/admin_email_process",
    };

    // bind to the form's submit event

    $("#email_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}


// pre-submit callback
function validate_email_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_email_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "setting";
    } else {
        alert(responseText);
    }
}



/*===================Update_copyright_text Admin Email ====================*/

function Update_copyright_text() { 
    $("#copyright_text").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_update_copyright_text_Request,

        success: validate_update_copyright_text_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/update_copyright_text",
    };

    // bind to the form's submit event

    $("#copyright_text").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

function validate_update_copyright_text_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_update_copyright_text_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "setting";
    } else {
        alert(responseText);
    }
}


/*===================Validate Change Password ====================*/

function validate_admin_password() {
    $("#change_pass_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_admin_password_Request,

        success: validate_admin_password_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/admin_change_password_process",
    };

    // bind to the form's submit event

    $("#change_pass_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_admin_password_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_admin_password_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "setting";
    } else {
        alert(responseText);
    }
}

/*===================Validate Country ====================*/

function validate_country() {
    $("#Country_frm").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_country_Request,

        success: validate_country_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/country_process",
    };

    // bind to the form's submit event

    $("#Country_frm").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_country_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_country_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "countries_listing";
    } else {
        alert(responseText);
    }
}

/*===================Validate Region ====================*/

function validate_region() {
    $("#region_frm").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_region_Request,

        success: validate_region_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/region_process",
    };

    // bind to the form's submit event

    $("#region_frm").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_region_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_region_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "regions_listing";
    } else {
        alert(responseText);
    }
}

/****************************Delete Review********************/

function delete_review_comment(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_review_comment",
            data: {
                del_id: del_id,
                _token: csrf_token,
            },

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete Regions********************/

function delete_region(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_regions",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete Regions********************/

function delete_region(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_regions",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete delete_sub_cate_more_info_data********************/
function delete_sub_cate_more_info_data(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/delete_sub_cate_more_info_data",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete country********************/

function delete_country(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_counntry",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete Main Category********************/

function delete_main_cat(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_main_category",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/*===================Validate Main Category ====================*/

function validate_main_cat() {
    $("#main_cat_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_main_cat_Request,

        success: validate_main_cat_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/main_cat_process",
    };

    // bind to the form's submit event

    $("#main_cat_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_main_cat_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_main_cat_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "main_cat_list";
    } else {
        alert(responseText);
    }
}

/*===================Validate Add Sub Category ====================*/

function validate_add_sub_cat() {
    $("#sub_cat_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_add_sub_cat_Request,

        success: validate_add_sub_cat_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/add_sub_cat_process",
    };

    // bind to the form's submit event

    $("#sub_cat_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_add_sub_cat_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}
function validate_add_sub_cat_Response(responseText, statusText) {
    var myarray = new Array();
    myarray = responseText.split("-SEPARATOR-");
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");
        if (myarray[1] == "sub") {
            window.location.href = JS_ADMIN_SERVER_PATHROOT + "sub_cat_list";
        } else {
            window.location.href = JS_ADMIN_SERVER_PATHROOT + "all_cat_list";
        }
    } else {
        alert(responseText);
    }
}
/*===================Validate Sub Category ====================*/

function validate_sub_cat() {
    $("#sub_cat_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_sub_cat_Request,

        success: validate_sub_cat_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/sub_cat_process",
    };

    // bind to the form's submit event

    $("#sub_cat_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_sub_cat_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_sub_cat_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "sub_cat_list";
    } else {
        alert(responseText);
    }
}

/****************************Delete Sub Category********************/

function delete_sub_cat(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_sub_category",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete Product********************/

function delete_product(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_product",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete FAQ********************/

function delete_faq(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_faq",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete ARTIST********************/
function delete_artist(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_artist",

            data: {
                _token: csrf_token,
                del_id: del_id,
            },

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location = "artist_list";
            },

            error: function () { },
        });
    } else {
        return;
    }
}

function delete_song(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Records?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",
            data: {
                del_id: del_id,
                _token: csrf_token,
            },
            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_song",
            beforeSend: function () { },
            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }
                window.location.reload();
            },
            error: function () { },
        });
    } else {
        return;
    }
}

function delete_artist_song(del_id, songid) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $('meta[name=csrf-token]').attr('content');
    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_artist_songs",

            data: {
                "del_id": del_id,
                "songid": songid,
                "_token": csrf_token,
            },

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/*===================Validate FAQ ====================*/

function validate_faq() {
    $("#faq_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_faq_Request,

        success: validate_faq_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/faq_process",
    };

    // bind to the form's submit event

    $("#faq_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_faq_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_faq_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "faq_list";
    } else {
        alert(responseText);
    }
}

/*===================Validate User ====================*/

function validate_user() {
    $("#user_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_user_Request,

        success: validate_user_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/user_process",
    };

    // bind to the form's submit event

    $("#user_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_user_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_user_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "users_list";
    } else {
        alert(responseText);
    }
}

/****************************Delete User********************/

function delete_user(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_user",
            data: {
                _token: csrf_token,
                del_id: del_id,
            },
            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete User********************/

function delete_slideshow(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_slide_show",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                }

                if (msg.search("Right-Error") != -1) {
                    alert("You have no right to delete this record");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete Ads********************/

function delete_ads(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_ads",
            data: {
                del_id: del_id,
                _token: csrf_token,
            },
            beforeSend: function () { },
            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }
                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/*===================Validate Page====================*/

function validate_page() {
    $("#page_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_page_Request,

        success: validate_page_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/pages_process",
    };

    // bind to the form's submit event

    $("#page_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_page_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_page_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "page_list";
    } else {
        alert(responseText);
    }
}

/*========================Load Category Type=======================================*/

function load_category_type(id) {
    if ((id == "Image" || id == "Text") && id != "") {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/get_ads_category",

            data: "cat_id=" + id,

            beforeSend: function () { },

            success: function (msg) {
                $("#cat_type_div").show();

                document.getElementById("cat_type_div").innerHTML = msg;
            },

            error: function () { },
        });
    } else {
        //document.getElementById("cat_type_div").style.display='none';

        $("#cat_type_div").hide();

        alert("Please Select Valid Category");

        return false;
    }
}

/*========================Load edit Category Type=======================================*/

function load_edit_category_type(id, update_id) {
    if ((id == "Image" || id == "Text") && id != "") {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/get_ads_edit_category",

            data: "cat_id=" + id + "&update_id=" + update_id,

            beforeSend: function () { },

            success: function (msg) {
                $("#cat_type_div").show();

                document.getElementById("cat_type_div").innerHTML = msg;
            },

            error: function () { },
        });
    } else {
        //document.getElementById("cat_type_div").style.display='none';

        $("#cat_type_div").hide();

        alert("Please Select Valid Category");

        return false;
    }
}

/*===================Validate Ads====================*/

function validate_ads() {
    $("#ads_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_ads_Request,

        success: validate_ads_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/ads_process",
    };

    // bind to the form's submit event

    $("#ads_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_ads_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_ads_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "ads_list";
    } else {
        alert(responseText);
    }
}

/*===================Validate Email Template====================*/

function validate_email_templates() {
    $("#email_templates_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_email_templates_Request,

        success: validate_email_templates_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/email_templates_process",
    };

    // bind to the form's submit event

    $("#email_templates_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_email_templates_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_email_templates_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href =
            JS_ADMIN_SERVER_PATHROOT + "email_templates_list";
    } else {
        alert(responseText);
    }
}

/****************************Set as Top Member********************/

function set_top_member(user_id) {
    var conBox = confirm("Are you sure,You want to set this as Top Member?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/set_top_member",

            data: "userid=" + user_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("User is set as Top Member");
                } else if (msg.search("full") != -1) {
                    alert("You can set Maximum 6 members as top member");
                } else {
                    alert("Some Error occured in updating Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************unSet as Top Member********************/

function unset_top_member(user_id) {
    var conBox = confirm("Are you sure,You want to UnSet Top Member?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/set_untop_member",

            data: "userid=" + user_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("User is UnSet Top Member");
                } else {
                    alert("Some Error occured in updating Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Set as Popular********************/

function set_popular(review_id) {
    var conBox = confirm("Are you sure,You want to set this as Popular?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/set_popular",

            data: {
                reviewid: review_id,
                _token: csrf_token,
            },

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Review is set as Popular");
                } else {
                    alert("Some Error occured in updating Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************unSet as Popular********************/

function unset_popular(review_id) {
    var conBox = confirm("Are you sure,You want to UnSet Popular?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/set_popular",

            data: {
                reviewid: review_id,
                _token: csrf_token,
            },

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Review is set UnPopular");
                } else {
                    alert("Some Error occured in updating Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete Review********************/

function delete_review(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_review",

            data: {
                del_id: del_id,
                _token: csrf_token,
            },
            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/*===================Validate Review ====================*/

function validate_review() {
    $("#review_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_review_Request,

        success: validate_review_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/review_process",
    };

    // bind to the form's submit event

    $("#review_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_review_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_review_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "reviews_list";
    } else {
        alert(responseText);
    }
}

/*===================Slide show Valdation====================*/

function validate_slide_show() {
    $("#slide_show_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_slide_show_Request,

        success: validate_slide_show_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/slide_show_process",
    };

    // bind to the form's submit event

    $("#slide_show_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_slide_show_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_slide_show_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "slide_show_list";
    } else {
        alert(responseText);
    }
}

/*===================Moderator Valdation====================*/

function validate_moderator() {
    $("#moderator_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_moderator_Request,

        success: validate_moderator_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/moderator_process",
    };

    // bind to the form's submit event

    $("#moderator_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_moderator_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_moderator_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "moderator_list";
    } else {
        alert(responseText);
    }
}

/****************************Delete Moderator********************/

function delete_moderator(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_moderator_process",

            data: {
                del_id: del_id,
                _token: csrf_token,
            },

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else if (msg.search("admin_delete") != -1) {
                    alert("Invalid Access");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/*===================Validate Report Option ====================*/

function validate_report_option() {
    $("#report_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_report_option_Request,

        success: validate_report_option_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/report_option_process",
    };

    // bind to the form's submit event

    $("#report_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_report_option_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_report_option_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href =
            JS_ADMIN_SERVER_PATHROOT + "report_checkbox_list";
    } else {
        alert(responseText);
    }
}

/****************************Delete Report Option********************/

function delete_report_option(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_report_option",

            data: {
                del_id: del_id,
                _token: csrf_token,
            },

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete Comment Report********************/

function delete_comment_report(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_comment_report",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Delete General Comment Report********************/

function delete_gcomment_report(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_gcomment_report",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/*================================ Moderator Rights Validatios========================================*/

function moderator_rights_validatation() {
    $("#moderator_right_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: moderator_rights_validatation_Request,

        success: moderator_rights_validatation_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/moderator_right_process",
    };

    // bind to the form's submit event

    $("#moderator_right_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function moderator_rights_validatation_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function moderator_rights_validatation_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "moderator_list";
    } else {
        alert(responseText);
    }
}

/*================================Show Rights==============================*/

function show_rights(id, type) {
    if (id == "Yes") {
        $("#" + type + "_div").show();
    } else {
        $("#" + type + "_div").hide();
    }
}

/*===================Site Mode Status====================*/

function validate_site_mode() {
    $("#site_mode_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_site_mode_Request,
        success: validate_site_mode_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/site_mode_process",
    };

    // bind to the form's submit event

    $("#site_mode_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_site_mode_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_site_mode_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "setting";
    } else {
        alert(responseText);
    }
}
/*===================Google Analaytic Status====================*/

function validate_analytic() {
    $("#analaytic_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_analaytic_Request,

        success: validate_analaytic_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/analytic_process",
    };

    // bind to the form's submit event

    $("#analaytic_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_analaytic_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_analaytic_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "setting";
    } else {
        alert(responseText);
    }
}

/*===================Validate Product ====================*/

function validate_product() {
    $("#product_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_product_Request,

        success: validate_product_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/product_process",
    };

    // bind to the form's submit event

    $("#product_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_product_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_product_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "product_list";
    } else {
        alert(responseText);
    }
}
/*===================Validate Product Embed Code====================*/
function validate_product_embed_code() {
    $("#product_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_product_embed_code_Request,
        success: validate_product_embed_code_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/embed_code_process",
    };
    // bind to the form's submit event
    $("#product_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_product_embed_code_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function validate_product_embed_code_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "embed_code_list";
    } else {
        alert(responseText);
    }
}
/****************************Delete Product Embed Code********************/

function delete_product_embed_code(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_product_embed_code",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}
/*===================Validate Product Embed Code====================*/
function validate_video() {
    $("#video_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_video_Request,
        success: validate_video_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/video_process",
    };
    // bind to the form's submit event
    $("#video_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_video_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function validate_video_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "video_list";
    } else {
        alert(responseText);
    }
}
/****************************Delete Product Embed Code********************/

function delete_video(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_video",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}
/****************************Delete Questions********************/

function delete_question(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_questions",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}
/****************************Delete Question********************/

function delete_question(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_questions",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}
/****************************Delete Answer********************/

function delete_answer(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_answer",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}
/****************************Delete Answer Like********************/

function delete_answer_like(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_answer_like",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}
/*===================Validate Category Image ====================*/

function validate_category_image() {
    $("#category_images_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_category_image_Request,

        success: validate_category_image_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/category_images_process",
    };

    // bind to the form's submit event

    $("#category_images_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_category_image_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_category_image_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "category_image_list";
    } else {
        alert(responseText);
    }
}
/****************************Delete Product********************/

function delete_category_image(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_category_image",

            data: "del_id=" + del_id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}
/*========================================get category level4 attributes===================*/
function get_category_level4_attributes(id) {
    if (id != "") {
        //this is level 4 id which is parent of level 5 we will add
        $.ajax({
            type: "POST",

            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level4_attributes_process",

            data: "level4_id=" + id,

            beforeSend: function () {
                $("#level5_attributes_id").hide();
            },

            success: function (msg) {
                if (msg != -1) {
                    $("#level5_attributes_id").show();
                    $("#level5_attributes_id").html(msg);
                } else {
                }
            },

            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        return;
    }
}

/*========================================get category level5 attributes===================*/
function get_category_level5_attributes(id) {
    if (id != "") {
        //this is level 4 id which is parent of level 5 we will add
        $.ajax({
            type: "POST",

            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level5_attributes_process",

            data: "level5_id=" + id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg != -1) {
                    $("#level5_attributes_id").show();
                    $("#level5_attributes_id").html(msg);
                } else {
                }
            },

            error: function () { },
        });
    } else {
        alert("Please select valid level5 category");
        return;
    }
}
/*========================================Load level2 category ===================*/
function get_category_level2_details(level1_id) {
    if (level1_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level2_details_process",
            data: "level1_id=" + level1_id,
            beforeSend: function () {
                $("#level5_attributes_id").hide();
                $("#load_level2_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level2_id").show();
                    $("#load_level2_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level2_id").hide();
        $("#load_level3_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Load level3 category ===================*/
function get_category_level3_details(level2_id) {
    if (level2_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level3_details_process",
            data: "level2_id=" + level2_id,
            beforeSend: function () {
                $("#level5_attributes_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level3_id").show();
                    $("#load_level3_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level3_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Load level4 category ===================*/
function get_category_level4_details(level3_id) {
    if (level3_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level4_details_process",
            data: "level3_id=" + level3_id,
            beforeSend: function () {
                $("#level5_attributes_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level4_id").show();
                    $("#load_level4_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Load level4 category ===================*/
function get_category_level5_details(level4_id) {
    if (level4_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level5_details_process",
            data: "level4_id=" + level4_id,
            beforeSend: function () { },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level5_id").show();
                    $("#load_level5_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        alert("Please select valid level5 category");
        return;
    }
}
/*===================Validate More Info Category====================*/
function validate_category_more_info() {
    $("#more_info_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_category_more_info_Request,
        success: validate_category_more_info_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/category_more_info_process",
    };
    // bind to the form's submit event
    $("#more_info_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_category_more_info_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function validate_category_more_info_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");
        window.location.href =
            JS_ADMIN_SERVER_PATHROOT + "sub_cat_more_info_list";
    } else {
        alert(responseText);
    }
}

/*===================Validate Mobile Ads====================*/

function validate_mobile_ads() {
    $("#ads_mobile_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_mobile_ads_Request,
        success: validate_mobile_ads_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/ads_mobile_process",
    };
    // bind to the form's submit event
    $("#ads_mobile_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}

// pre-submit callback
function validate_mobile_ads_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function validate_mobile_ads_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "ads_mobile_list";
    } else {
        alert(responseText);
    }
}

/****************************Delete Ads********************/

function delete_mobile_ads(del_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    if (conBox) {
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_mobile_ads",
            data: "del_id=" + del_id,
            beforeSend: function () { },
            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }
                window.location.reload();
            },
            error: function () { },
        });
    } else {
        return;
    }
}

/*========================================Load level2 category ===================*/
function get_category_level1_details(level) {
    if (level != "") {
        if (level == "2") {
            var process_file = "category_level1_details_process";
        } else if (level == "3") {
            var process_file = "category_level2_process";
        } else if (level == "4") {
            var process_file = "category_level3_process";
        } else if (level == "5") {
            var process_file = "category_level3_process";
        }
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/" + process_file,
            data: "level=" + level,
            beforeSend: function () {
                $("#load_level1_id").hide();
                $("#load_level2_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
                $("#level5_attributes_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level1_id").show();
                    $("#load_level1_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level1_id").hide();
        $("#load_level2_id").hide();
        $("#load_level3_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}
/*========================================Load level2 category ===================*/
function get_category_level2_data(level1_id) {
    if (level1_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level2_data_process",
            data: "level1_id=" + level1_id,
            beforeSend: function () {
                $("#level5_attributes_id").hide();
                $("#load_level2_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level2_id").show();
                    $("#load_level2_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level2_id").hide();
        $("#load_level3_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}
/*========================================Load level4 category ===================*/
function get_category_level4_data(level3_id) {
    if (level3_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level4_data_process",
            data: "level3_id=" + level3_id,
            beforeSend: function () {
                $("#level5_attributes_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level4_id").show();
                    $("#load_level4_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Edit Load level2 category ===================*/
function edit_category_level2_details(level1_id, selected_level2_id) {
    if (level1_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level2_details_process",
            data:
                "level1_id=" +
                level1_id +
                "&selected_level2_id=" +
                selected_level2_id,
            beforeSend: function () {
                $("#level5_attributes_id").hide();
                $("#load_level2_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level2_id").show();
                    $("#load_level2_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level2_id").hide();
        $("#load_level3_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Edit Load level3 category ===================*/
function edit_category_level3_details(level2_id, selected_id) {
    if (level2_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level3_details_process",
            data:
                "level2_id=" + level2_id + "&selected_level2_id=" + selected_id,
            beforeSend: function () {
                $("#level5_attributes_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level3_id").show();
                    $("#load_level3_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level3_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Load level4 category ===================*/
function edit_category_level4_details(level3_id, selected_id) {
    if (level3_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level4_details_process",
            data:
                "level3_id=" + level3_id + "&selected_level3_id=" + selected_id,
            beforeSend: function () {
                $("#level5_attributes_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level4_id").show();
                    $("#load_level4_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#level5_attributes_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Edit Load level4 category ===================*/
function edit_category_level5_details(level4_id, selected_id) {
    if (level4_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level5_details_process",
            data:
                "level4_id=" + level4_id + "&selected_level4_id=" + selected_id,
            beforeSend: function () { },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level5_id").show();
                    $("#load_level5_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        alert("Please select valid level5 category");
        return;
    }
}

/*========================================Edit category level5 attributes===================*/
function edit_category_level5_attributes(id) {
    if (id != "") {
        //this is level 4 id which is parent of level 5 we will add
        $.ajax({
            type: "POST",

            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level5_attributes_process",

            data: "level5_id=" + id,

            beforeSend: function () { },

            success: function (msg) {
                if (msg != -1) {
                    $("#level5_attributes_id").show();
                    $("#level5_attributes_id").html(msg);
                } else {
                }
            },

            error: function () { },
        });
    } else {
        alert("Please select valid level5 category");
        return;
    }
}

/*===================Validate Edit Sub Category ====================*/
function validate_edit_sub_cat() {
    $("#edit_sub_cat_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_edit_sub_cat_Request,
        success: validate_edit_sub_cat_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/edit_sub_cat_process",
    };
    // bind to the form's submit event
    $("#edit_sub_cat_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_edit_sub_cat_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function validate_edit_sub_cat_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "sub_cat_list";
    } else {
        alert(responseText);
    }
}

/*========================================Load level2 review category ===================*/
function category_level2_review(level1_id) {
    if (level1_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level2_review_process",
            data: "level1_id=" + level1_id,
            beforeSend: function () {
                $("#load_level5_id").hide();
                $("#load_level2_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level2_id").show();
                    $("#load_level2_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#load_level5_id").hide();
        $("#load_level2_id").hide();
        $("#load_level3_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Load level3 category ===================*/
function category_level3_review(level2_id) {
    if (level2_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level3_review_process",
            data: "level2_id=" + level2_id,
            beforeSend: function () {
                $("#load_level5_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level3_id").show();
                    $("#load_level3_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#load_level5_id").hide();
        $("#load_level4_id").hide();
        $("#load_level3_id").hide();
        return;
    }
}

/*========================================Load level4 category ===================*/
function category_level4_review(level3_id) {
    if (level3_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level4_review_process",
            data: "level3_id=" + level3_id,
            beforeSend: function () {
                $("#load_level5_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level4_id").show();
                    $("#load_level4_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#load_level5_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Load level5 review category ===================*/
function get_category_level5_review(level4_id) {
    if (level4_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/category_level5_review_process",
            data: "level4_id=" + level4_id,
            beforeSend: function () { },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level5_id").show();
                    $("#load_level5_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#load_level5_id").hide();
    }
}
/*===================Validate add Review ====================*/

function validate_add_review() {
    $("#add_review_form").unbind("submit");

    var options = {
        target: "",

        beforeSubmit: validate_add_review_Request,

        success: validate_add_review_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/add_review_process",
    };

    // bind to the form's submit event

    $("#add_review_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_add_review_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_add_review_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "reviews_list";
    } else {
        alert(responseText);
    }
}
/*===================Validate Edit Review ====================*/

function validate_edit_review() {
    $("#edit_review_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_edit_review_Request,

        success: validate_edit_review_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/edit_review_process",
    };

    // bind to the form's submit event

    $("#edit_review_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_edit_review_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_edit_review_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "reviews_list";
    } else {
        alert(responseText);
    }
}

/*========================================Load level2 Edit review category ===================*/
function edit_category_level2_review(level1_id, reviews_id) {
    if (level1_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level2_review_process",
            data: "level1_id=" + level1_id + "&reviews_id=" + reviews_id,
            beforeSend: function () {
                $("#load_level5_id").hide();
                $("#load_level2_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level2_id").show();
                    $("#load_level2_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#load_level5_id").hide();
        $("#load_level2_id").hide();
        $("#load_level3_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Load level3 Edit review category ===================*/
function edit_category_level3_review(level2_id, reviews_id) {
    if (level2_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level3_review_process",
            data: "level2_id=" + level2_id + "&reviews_id=" + reviews_id,
            beforeSend: function () {
                $("#load_level5_id").hide();
                $("#load_level3_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level3_id").show();
                    $("#load_level3_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#load_level5_id").hide();
        $("#load_level4_id").hide();
        $("#load_level3_id").hide();
        return;
    }
}

/*========================================Load level4 Edit review category ===================*/
function edit_category_level4_review(level3_id, reviews_id) {
    if (level3_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level4_review_process",
            data: "level3_id=" + level3_id + "&reviews_id=" + reviews_id,
            beforeSend: function () {
                $("#load_level5_id").hide();
                $("#load_level4_id").hide();
            },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level4_id").show();
                    $("#load_level4_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#load_level5_id").hide();
        $("#load_level4_id").hide();
        return;
    }
}

/*========================================Load level5 edit review category ===================*/
function edit_category_level5_review(level4_id, reviews_id) {
    if (level4_id != "") {
        $.ajax({
            type: "POST",
            url:
                JS_ADMIN_SERVER_PATHROOT +
                "process/edit_category_level5_review_process",
            data: "level4_id=" + level4_id + "&reviews_id=" + reviews_id,
            beforeSend: function () { },
            success: function (msg) {
                if (msg != -1) {
                    $("#load_level5_id").show();
                    $("#load_level5_id").html(msg);
                } else {
                }
            },
            error: function () { },
        });
    } else {
        $("#load_level5_id").hide();
    }
}

/*===================Validate Allocate Review ====================*/

function validate_allocate_review() {
    $("#allocate_review_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_allocate_review_Request,
        success: validate_allocate_review_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/allocate_review_process",
    };
    // bind to the form's submit event
    $("#allocate_review_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_allocate_review_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function validate_allocate_review_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "reviews_list";
    } else {
        alert(responseText);
    }
}
/*===================Validate General Setting====================*/
function validate_general_setting() {
    $("#setting_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_general_setting_Request,
        success: validate_general_setting_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/general_setting_process",
    };
    // bind to the form's submit event
    $("#setting_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_general_setting_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function validate_general_setting_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "general_setting";
    } else {
        alert(responseText);
    }
}

/*===================validate_social_icon====================*/
function validate_social_icon() {
    $(".social_icons").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_social_icon_Request,
        success: validate_social_icon_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/social_icons_process",
    };
    // bind to the form's submit event
    $(".social_icons").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_social_icon_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function validate_social_icon_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "social_icons";
    } else {
        alert(responseText);
    }
}

/****************************Set as Feature Review********************/

function set_featured_review(review_id) {
    var conBox = confirm(
        "Are you sure,You want to set this as Featured Review?"
    );
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/featured_review_process",

            data: {
                reviewid: review_id,
                _token: csrf_token,
            },
            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Review is set as Featured Review");
                    window.location.reload();
                } else if (msg.search("Exist") != -1) {
                    alert(
                        "You have already select Feature Review for this category"
                    );
                } else {
                    alert("Some Error occured in updating Record");
                    window.location.reload();
                }
            },
            error: function () { },
        });
    } else {
        return;
    }
}

/****************************unSet as Feature Review********************/

function unset_featured_review(review_id) {
    var conBox = confirm("Are you sure,You want to UnSet Featured Review?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/featured_review_process",

            data: {
                reviewid: review_id,
                _token: csrf_token,
            },

            beforeSend: function () { },

            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Review is set UnFeatured Review");
                } else {
                    alert("Some Error occured in updating Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

/****************************Set as Feature Topic********************/
function set_featured_topic(review_topic_id) {
    var conBox = confirm(
        "Are you sure,You want to set this as Featured Topic?"
    );
    if (conBox) {
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/featured_topic_process",
            data: "review_topic_id=" + review_topic_id,
            beforeSend: function () { },
            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Review Topic is set as Featured Topic");
                } else {
                    alert("Some Error occured in updating Record");
                }
                window.location.reload();
            },
            error: function () { },
        });
    } else {
        return;
    }
}
/****************************unSet as Feature Topic********************/
function unset_featured_topic(review_topic_id) {
    var conBox = confirm("Are you sure,You want to UnSet Featured Topic?");
    if (conBox) {
        $.ajax({
            type: "POST",
            url: JS_ADMIN_SERVER_PATHROOT + "process/featured_topic_process",
            data: "review_topic_id=" + review_topic_id,
            beforeSend: function () { },
            success: function (msg) {
                if (msg.search("done") != -1) {
                    alert("Review Topic is set UnFeatured Topic");
                } else {
                    alert("Some Error occured in updating Record");
                }
                window.location.reload();
            },
            error: function () { },
        });
    } else {
        return;
    }
}

/*===================Validate Edit Discussion ====================*/
function validate_edit_discussion() {
    $("#edit_discussion_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        data: {
            _token: csrf_token,
        },
        target: "",
        beforeSubmit: validate_edit_discussion_Request,
        success: validate_edit_discussion_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/edit_discussion_process",
    };
    // bind to the form's submit event
    $("#edit_discussion_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}

// pre-submit callback
function validate_edit_discussion_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function validate_edit_discussion_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "gcomments";
    } else {
        alert(responseText);
    }
}

/*===================Validate Edit Comment ====================*/
function validate_edit_comment() {
    $("#edit_comment_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_edit_comment_Request,
        success: validate_edit_comment_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/edit_comment_process",
    };
    // bind to the form's submit event
    $("#edit_comment_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}

// pre-submit callback
function validate_edit_comment_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function validate_edit_comment_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "comments_list";
    } else {
        alert(responseText);
    }
}

/*===================Validate Edit Answer ====================*/
function validate_edit_answer() {
    $("#edit_answer_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_edit_answer_Request,
        success: validate_edit_answer_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/edit_answer_process",
    };
    // bind to the form's submit event
    $("#edit_answer_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}

// pre-submit callback
function validate_edit_answer_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function validate_edit_answer_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "answer_list";
    } else {
        alert(responseText);
    }
}

/*===================Validate Edit Question ====================*/
function validate_edit_question() {
    $("#edit_question_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_edit_question_Request,
        success: validate_edit_question_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/edit_question_process",
    };
    // bind to the form's submit event
    $("#edit_question_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}

// pre-submit callback
function validate_edit_question_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function validate_edit_question_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Save Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "question_list";
    } else {
        alert(responseText);
    }
}

/*===================Validate level 2-4 categories ====================*/
function validate_sub_categories() {
    $("#sub_categories_form").unbind("submit");
    var options = {
        target: "",
        beforeSubmit: validate_sub_categories_Request,
        success: validate_sub_categories_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/sub_categories_process",
    };
    // bind to the form's submit event
    $("#sub_categories_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_sub_categories_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}
function validate_sub_categories_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "all_cat_list";
    } else {
        alert(responseText);
    }
}

// here is validate artist

function validate_artist() {
    $("#artist_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_artist_Request,
        success: validate_artist_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/artist_process",
    };
    // bind to the form's submit event
    $("#artist_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}

// pre-submit callback

function validate_artist_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    document.getElementById("loader").innerHTML =
        "<img src=" + JS_ADMIN_SERVER_PATHROOT + "images/load.gif>";
    $("#add").hide();
    $("#save").hide();

    return true;
}

function validate_artist_Response(responseText, statusText) {
    document.getElementById("loader").innerHTML = "";
    $("#add").show();
    $("#save").show();
    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "artist_list";
    } else {
        alert(responseText);
    }
}

// validate album
// here is validate artist

function validate_album() {
    $("#album_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_album_Request,

        success: validate_album_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/album_process",
    };

    // bind to the form's submit event

    $("#album_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_album_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    document.getElementById("loader").innerHTML =
        "<img src=" + JS_ADMIN_SERVER_PATHROOT + "images/load.gif>";
    $("#add").hide();
    $("#save").hide();
    return true;
}

function validate_album_Response(responseText, statusText) {
    document.getElementById("loader").innerHTML = "";
    $("#add").show();
    $("#save").show();
    myarray = responseText.split("-SEPARATOR-");

    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = myarray[1];
    } else {
        alert(responseText);
    }
}

function delete_album(del_id, artist_id) {
    var conBox = confirm("Are you sure,you want to delete this Record?");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (conBox) {
        $.ajax({
            type: "POST",

            url: JS_ADMIN_SERVER_PATHROOT + "process/delete_album",

            data: {
                del_id: del_id,
                artist_id: artist_id,
                _token: csrf_token,
            },

            beforeSend: function () { },

            success: function (msg) {
                myarray = msg.split("-SEPARATOR-");

                if (msg.search("done") != -1) {
                    alert("Record Delete Successfully");
                } else {
                    alert("Some Error occured in deleting Record");
                }

                window.location.reload();
            },

            error: function () { },
        });
    } else {
        return;
    }
}

// here is validate song

function validate_song() {
    $("#song_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_song_Request,
        success: validate_song_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/song_process",
    };
    // bind to the form's submit event
    $("#song_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_song_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    document.getElementById("loader").innerHTML =
        "<img src=" + JS_ADMIN_SERVER_PATHROOT + "images/load.gif>";
    $("#add").hide();
    $("#save").hide();
    return true;
}
function validate_song_Response(responseText, statusText) {
    document.getElementById("loader").innerHTML = "";
    $("#add").show();
    $("#save").show();

    if (responseText.search("done") != -1) {
        myarray = responseText.split("-SEPARATOR-");
        alert("Record Saved Successfully");
        window.location.href = myarray[1];
    } else {
        alert(responseText);
    }
}

// here is validate song artist album
function validate_song_artist_album() {
    $("#song_form").unbind("submit");
    var csrf_token = $('meta[name=csrf-token]').attr('content');



    var options = {
        target: "",
        data: {
            "_token": csrf_token,
        },
        beforeSubmit: validate_song_artist_album_Request,
        success: validate_song_artist_album_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/song_artist_album_process",
    };

    // bind to the form's submit event

    $("#song_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

function validate_featured_atritst_assocs() {
    $("#featured_song_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_song_artist_album_Request,
        success: validate_songs_featured_assocs_response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/featured_artist_album_assocs",
    };

    // bind to the form's submit event

    $("#featured_song_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}
function validate_songs_featured_assocs_response(responseText, statusText) {
    document.getElementById("loader").innerHTML = "";
    $("#add").show();
    $("#save").show();

    myarray = responseText.split("-SEPARATOR-");

    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");
        if(myarray[1] == 'song_list')
        {
            window.location.href =
            JS_ADMIN_SERVER_PATHROOT + myarray[1];
        }else
        {
            window.location.href = myarray[1];
            window.location.href =
                JS_ADMIN_SERVER_PATHROOT + "artist_album_songs_list?" + myarray[1];
        }
       
    } else {
        alert(responseText);
    }
}

// pre-submit callback

function validate_song_artist_album_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    document.getElementById("loader").innerHTML =
        "<img src=" + JS_ADMIN_SERVER_PATHROOT + "images/load.gif>";
    $("#add").hide();
    $("#save").hide();
    return true;
}

function validate_song_artist_album_Response(responseText, statusText) {
    document.getElementById("loader").innerHTML = "";
    $("#add").show();
    $("#save").show();
    var myarray = new Array();
    myarray = responseText.split("-SEPARATOR-");

    if (responseText.search("done") != -1) {
        alert("Record Saved Successfully");

        window.location.href = myarray[1];
    } else {
        alert(responseText);
    }
}

function jump_char(val) {
    $.ajax({
        type: "POST",

        url: JS_ADMIN_SERVER_PATHROOT + "process/artist_list_process",

        data: "pass_val=" + val,

        beforeSend: function () { },

        success: function (msg) {
            $("#jump_div").show();
            $("#hide_first").hide();

            document.getElementById("jump_div").innerHTML = msg;
        },

        error: function () { },
    });
}

function artist_check(val) {
    alert(val);
}
//Stores Images
function validate_store_images() {
    $("#store_images_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },
        beforeSubmit: validate_store_images_Request,
        success: validate_store_images_Response,
        url: JS_ADMIN_SERVER_PATHROOT + "process/store_images_process",
    };
    // bind to the form's submit event
    $("#store_images_form").submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });
}
// pre-submit callback
function validate_store_images_Request(formData, jqForm, options) {
    var queryString = $.param(formData);
    document.getElementById("loader").innerHTML =
        "<img src=" + JS_ADMIN_SERVER_PATHROOT + "images/load.gif>";
    $("#add").hide();
    $("#save").hide();
    return true;
}
function validate_store_images_Response(responseText, statusText) {
    document.getElementById("loader").innerHTML = "";
    $("#add").show();
    $("#save").show();
    if (responseText.search("done") != -1) {
        alert("Saved Successfully");
        window.location.href = JS_ADMIN_SERVER_PATHROOT + "images_list";
    } else {
        alert(responseText);
    }
}

/*here is code for validation itune url*/

function validate_itune() {
    $("#itune_form").unbind("submit");
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    var options = {
        target: "",
        data: {
            _token: csrf_token,
        },

        beforeSubmit: validate_itune_Request,

        success: validate_itune_Response,

        url: JS_ADMIN_SERVER_PATHROOT + "process/itune_process",
    };

    // bind to the form's submit event

    $("#itune_form").submit(function () {
        $(this).ajaxSubmit(options);

        return false;
    });
}

// pre-submit callback

function validate_itune_Request(formData, jqForm, options) {
    var queryString = $.param(formData);

    return true;
}

function validate_itune_Response(responseText, statusText) {
    if (responseText.search("done") != -1) {
        alert("Record Update Successfully");

        window.location.href = JS_ADMIN_SERVER_PATHROOT + "setting";
    } else {
        alert(responseText);
    }
}
