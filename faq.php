<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Discover - FAQ</title>

    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-select.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-editable.css"/>
    <link rel="stylesheet" href="css/ionicons.css"/>
    <link rel="stylesheet" href="css/discover.css"/>

    <script src="vendor/jquery-1.11.1.min.js"></script>
    <script src="js/common.js"></script>
    <script src="vendor/bootstrap.js"></script>

</head>
<body>
<?php
if(isset($_SESSION["user_id"])){
    include_once('partials/navbar_member.php');
}else{
    include_once('partials/navbar.php');
}
?>

<section class="container content-faq">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="title">FAQ</h3>
            <div class="line-center"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <div class="panel-group" id="accordion" role="tablist">
                <div class="panel">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        <i class="fa fa-question"></i> What is Discover?</a>
                    </h4>
                    <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                        <div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. </div>
                    </div>
                </div>
                <div class="panel">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2">
                            <i class="fa fa-male"></i> How do i become a partner?</a>
                    </h4>
                    <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                        <div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. </div>
                    </div>
                </div>
                <div class="panel">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <i class="fa fa-paypal"></i> What payment formats are accepted?</a>
                    </h4>
                    <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                        <div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. </div>
                    </div>
                </div>
                <div class="panel">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4">
                            <i class="fa fa-rocket"></i> How can I enhance my experience?</a>
                    </h4>
                    <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                        <div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. </div>
                    </div>
                </div>
                <div class="panel">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="true" aria-controls="collapse5">
                            <i class="fa fa-user"></i> How do i create an account?</a>
                    </h4>
                    <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                        <div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. </div>
                    </div>
                </div>
                <div class="panel">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="true" aria-controls="collapse6">
                            <i class="fa fa-asterisk"></i> How do i reset my password?</a>
                    </h4>
                    <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                        <div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco. </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include_once('partials/footer.php'); ?>

</body>
</html>