<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Discover</title>

    <link rel="stylesheet" href="/css/bootstrap.css"/>
    <link rel="stylesheet" href="/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/css/bootstrap-select.min.css"/>
    <link rel="stylesheet" href="/css/bootstrap-editable.css"/>
    <link rel="stylesheet" href="/css/ionicons.css"/>
    <link rel="stylesheet" href="/css/discover.css"/>

    <script src="/vendor/jquery-1.11.1.min.js"></script>
    <script src="/js/common.js"></script>
    <script src="/vendor/bootstrap.js"></script>

</head>
<body>
<?php
session_start();
if(isset($_SESSION["user_id"])){
    include_once('../partials/navbar_member.php');
}else{
    include_once('../partials/navbar.php');
}
?>

<section class="container content-dashboard">
    <div class="row">
        <div class="col-sm-3">
            <div class="side-bar">
                <span class="header">Hello, <?php echo $_SESSION['user_forename'].' '.$_SESSION['user_surname']; ?></span>
                <ul>
                    <li><a href="/profile">Profile</a></li>
                    <li class="active"><a href="/campaign/">Campaigns</a></li>
                    <li><a href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="title">MY CAMPAIGNS</h3>
                    <div class="line-left"></div>
                </div>
                <?php
                include_once('../db.php');

                $stmt = $db->prepare("SELECT id,title,type,formatted_address,logo FROM adverts WHERE owner = ?");
                $stmt->bind_param('i',$_SESSION['user_id']);
                $stmt->execute();
                $stmt->bind_result($id,$title,$type,$address,$logo);
                ?>

                <?php while($stmt->fetch()):?>
                    <div class="col-xs-12 campaign">
                        <div class="row">
                            <div class="col-xs-2">
                                <img src="<?php echo $logo; ?>" class="img-responsive"/>
                            </div>
                            <div class="col-xs-10">
                                <h4><?php echo $title; ?></h4>
                                <p><?php echo $address; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile ?>
                <?php if($stmt->num_rows == 0):?>
                    <p>No campaigns found. <a href="create">Create one</a>.</p>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>


<?php include_once('../partials/footer.php'); ?>

</body>
</html>