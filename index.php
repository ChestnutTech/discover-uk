<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Discover</title>

    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-select.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-editable.css"/>
    <link rel="stylesheet" href="css/ionicons.css"/>
    <link rel="stylesheet" href="css/discover.css"/>

    <script src="vendor/jquery-1.11.1.min.js"></script>
    <script src="vendor/bootstrap.js"></script>
    <script src="js/common.js"></script>
</head>
<body>

<?php
session_start();
if(isset($_SESSION["user_id"])){
    include_once('partials/navbar_member.php');
}else{
    include_once('partials/navbar.php');
}
?>

    <section class="container-full banner">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="banner-caption">
                        Explore great opportunities near<br> you now
                        <br>
                        <a href="/register">GET STARTED</a>
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="container content-box-lg">
        <div class="row">
            <div class="col-sm-4">
                <div class="featured-content">
                    <i class="fa fa-map-marker"></i>
                    <h3>Community<br> focused</h3>
                    <p>
                        Quick response with regular updates.
                        Each update will include great new features and enhancements for free.
                    </p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="featured-content">
                    <i class="fa fa-tree"></i>
                    <h3>Environmentally<br> friendly</h3>
                    <p>
                        Quick response with regular updates.
                        Each update will include great new features and enhancements for free.
                    </p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="featured-content">
                    <i class="fa fa-coffee"></i>
                    <h3>Satisfaction<br> guaranteed</h3>
                    <p>
                        Quick response with regular updates.
                        Each update will include great new features and enhancements for free.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="container-full bg-dark content-box-sm">
        <div class="container content-subscribe">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="title">Subscribe to our weekly offers</h3>
                    <div class="body">Lorem ipsum dolor sit amet consectetuer adipiscing elit sed diam nonummy nibh euismod</div>
                </div>
                <div class="col-sm-6">
                    <form action="#">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control input-lg" placeholder="Your Email Here">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-theme btn-uppercase">SUBSCRIBE</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container content-box-lg content-category">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="title">Categories</h3>
                <div class="line-center"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="category-card">
                    <div class="overlay">
                        <div class="grey-tile">
                            <div class="tile-content">
                                <a href="/">Show more</a>
                            </div>
                        </div>
                        <div class="reduced">15% off</div>
                        <img src="images/music.jpg" class="image"/>
                    </div>
                    <div class="info">
                        <span class="title">Music</span>
                        <span> - 18 promotions</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="category-card">
                    <div class="overlay">
                        <div class="grey-tile">
                            <div class="tile-content">
                                <a href="/">Show more</a>
                            </div>
                        </div>
                        <div class="reduced">14% off</div>
                        <img src="images/sports.jpg" class="image"/>
                    </div>
                    <div class="info">
                        <span class="title">Sports</span>
                        <span> - 32 promotions</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="category-card">
                    <div class="overlay">
                        <div class="grey-tile">
                            <div class="tile-content">
                                <a href="/">Show more</a>
                            </div>
                        </div>
                        <div class="reduced">6% off</div>
                        <div class="new">new</div>
                        <img src="images/hotels.jpg" class="image"/>
                    </div>
                    <div class="info">
                        <span class="title">Hotels</span>
                        <span> - 109 promotions</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="category-card">
                    <div class="overlay">
                        <div class="grey-tile">
                            <div class="tile-content">
                                <a href="/">Show more</a>
                            </div>
                        </div>
                        <div class="reduced">23% off</div>
                        <div class="new">new</div>
                        <img src="images/food.jpg" class="image"/>
                    </div>
                    <div class="info">
                        <span class="title">Dinning</span>
                        <span> - 20 promotions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('partials/footer.php'); ?>

</body>
</html>












