<!-- load css -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"> -->
<link
    href="<?php echo SERVER_ROOTPATH; ?>css/our4.css?id=<?php echo rand(10000, 9999999); ?>"
    rel="stylesheet" media="all">
<link
    href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/main11.css?id=<?php echo rand(10000, 9999999); ?>"
    rel="stylesheet" media="all">
<link
    href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/custom-style-new.css?id=<?php echo rand(0, 2000); ?>"
    rel="stylesheet" media="all">
<link
    href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/style-update-new.css?id=<?php echo rand(0, 2000); ?>"
    rel="stylesheet" media="all">
<link rel="stylesheet"
    href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/star-rating.css"
    media="all" type="text/css" />
<link rel="stylesheet" type="text/css"
    href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/style-update.css?id=<?php echo rand(111111, 9999999); ?>">
<link rel="stylesheet" type="text/css"
    href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/responsive.css">

<?php if ($currentFile == 'sign-in' || $currentFile == 'forgot_password' || $currentFile == 'edit_social_icons' || $currentFile == 'sign-up' ||  $currentFile == 'edit_review' ||  $currentFile == 'edit_comment' ||  $currentFile == 'contact-us' ||  $currentFile == 'cms' ||  $currentFile == 'change_password'  ||  $currentFile == 'edit_username' ||  $currentFile == 'change_picture' ||  $currentFile == 'new_password') { ?>
<link rel="stylesheet" type="text/css"
    href="<?php echo COOKIE_FREE_ROOTPATH; ?>css/form.css">

<?php } ?>




<!-- load js -->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script type="text/javascript"
    src="<?php echo SERVER_ROOTPATH; ?>js/jquery.js?id=<?php echo rand(10000, 9999999); ?>">
</script>
<script type="text/javascript"
    src="<?php echo SERVER_ROOTPATH; ?>js/bootstrap.js">
</script>

<script type="text/javascript"
    src="<?php echo COOKIE_FREE_ROOTPATH; ?>js/merged.min.js" async></script>
<script type="text/javascript"
    src="<?php echo SERVER_ROOTPATH; ?>js/ourjs14.js?id=<?php echo rand(10000, 9999999); ?>">
</script>

<script src='<?php echo COOKIE_FREE_ROOTPATH; ?>js/jquery.MetaData.js'
    type="text/javascript" language="javascript"></script>
<script type="text/javascript"
    src="<?php echo COOKIE_FREE_ROOTPATH; ?>js/custom.js"></script>

<!-- clear   -->
<?php if ($currentFile == 'artists') { ?>
<!--<script type='text/javascript' src='<?php echo COOKIE_FREE_ROOTPATH; ?>js/jquery.autocomplete.js'>
</script>-->

<script type="text/javascript">
    function unset_all() {
        window.location.href = "<?php echo SERVER_ROOTPATH; ?>artist/unset";
    }
</script>
<script type="text/javascript">
    $().ready(function() {
        $("#search_text").autocomplete(
            "<?php echo SERVER_ROOTPATH; ?>get_artist_list", {
                width: 300,
                matchContains: true,
                selectFirst: false
            });
    });
</script>
<?php } ?>


<style>
    .bottom_nav,
    .bottom_nav li {
        display: inline-block;
        vertical-align: middle;
    }

    .sprite {
        background-image: url("<?php echo COOKIE_FREE_ROOTPATH; ?>images/icons.png");
        background-repeat: no-repeat;
        display: block;
    }

    .sprite-icon_fb {
        width: 34px;
        height: 34px;
        background-position: -5px -5px;
    }

    .sprite-icon_ggl {
        width: 34px;
        height: 34px;
        background-position: -49px -5px;
    }

    .sprite-icon_itune {
        width: 104px;
        height: 35px;
        background-position: -5px -49px;
    }

    .sprite-icon_music_white {
        width: 23px;
        height: 26px;
        background-position: -76px -5px;
    }

    .sprite-icon_musichead {
        width: 33px;
        height: 32px;
        background-position: -109px -5px;
    }

    .sprite-icon_search {
        width: 22px;
        height: 22px;
        background-position: -119px -47px;
    }

    .sprite-icon_tw {
        width: 34px;
        height: 34px;
        background-position: -119px -79px;
    }

    .sprite-owl_next {
        width: 25px;
        height: 47px;
        background-position: -5px -104px;
    }

    .sprite-owl_prev {
        width: 25px;
        height: 47px;
        background-position: -40px -104px;
    }



    .sprite-new {
        background-image: url("<?php echo COOKIE_FREE_ROOTPATH; ?>images/iconsheet.png");
        background-repeat: no-repeat;
        display: inline-block;
    }

    .sprite-new-icon_search {
        width: 22px;
        height: 22px;
        background-position: -5px -5px;
    }

    .sprite-new-icon_signup {
        width: 27px;
        height: 31px;
        background-position: -37px -5px;
        vertical-align: middle;
        margin-right: 8px;

    }

    .sprite-new-icon_time {
        width: 24px;
        height: 24px;
        background-position: -5px -46px;
        vertical-align: middle;
        margin-right: 4px;
    }

    .sprite-new-icon_user {
        width: 24px;
        height: 24px;
        background-position: -39px -46px;
        vertical-align: middle;
        margin-right: 4px;
    }

    .sprite-new-xicon_signin-png-pagespeed-ic-d7QTJCwNDt {

        background-position: -74px -5px;
        background-position: -74px -5px;
        height: 29px;
        margin-right: 8px;
        vertical-align: middle;
        width: 29px;
    }

    .sprite-new-xsearch-icon-png-pagespeed-ic-XjnYgjYQAr {
        width: 20px;
        height: 20px;
        background-position: -74px -44px;
    }

    .banner-search button.btn,
    .banner-search input.btn,
    .banner-search submit.btn {
        background: #fff none repeat scroll 0 0 !important;
        border-left: 1px solid #d6d6d6 !important;
        ;
        font-size: 0 !important;
        ;
        height: auto !important;
        ;
        padding-left: 7px !important;

    }

    .account_nav li a.signin {

        background: rgba(0, 0, 0, 0) !important;
    }

    .account_nav li a.signup {
        background: rgba(0, 0, 0, 0) !important;
    }

    .account_nav li a {
        padding: 5px !important;

    }
</style>