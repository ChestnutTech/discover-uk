<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Discover - Secure Login</title>

    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-select.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-editable.css"/>
    <link rel="stylesheet" href="css/ionicons.css"/>
    <link rel="stylesheet" href="css/discover.css"/>

    <script src="vendor/jquery-1.11.1.min.js"></script>
    <script src="vendor/bootstrap.js"></script>
    <script src="vendor/bootstrap-select.min.js"></script>
    <script src="js/common.js"></script>
    <script src="js/create.js"></script>

</head>
<body>
<?php
if(isset($_SESSION["user_id"])){
    include_once('partials/navbar_member.php');
}else{
    include_once('partials/navbar.php');
}
?>

<section class="container content-404">
    <div class="row">
        <div class="col-xs-12">
            <h3 class="title">404: Page not found</h3>
            <div class="line-center"></div>
            <p>This page either does not exist or has been moved.</p>
        </div>
    </div>
</section>

<?php include_once('partials/footer.php'); ?>

</body>
</html>