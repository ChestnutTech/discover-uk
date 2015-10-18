<?php
session_start();
?>
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
    <script src="vendor/bootstrap-select.min.js"></script>
    <script src="vendor/bootstrap-editable.js"></script>
    <script src="vendor/jquery.mixitup.js"></script>
    <script src="vendor/mustache.min.js"></script>
    <script src="js/LocationEngine.js"></script>
    <script src="js/common.js"></script>
    <script src="js/search.js"></script>
</head>
<body>
    <?php
    if(isset($_SESSION["user_id"])){
        include_once('partials/navbar_member.php');
    }else{
        include_once('partials/navbar.php');
    }
    ?>

    <?php include_once('partials/filterbar_1.php'); ?>

    <section class="container card-container">
        <div class="row">
            <div class="col-xs-12">
                <h3>Search Results</h3>
            </div>
            <div id="results">
                <div class="text-center">
                    <i class="icon ion-loading-c large"></i>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('partials/footer.php'); ?>

    <!-- Templates -->
    <script type="text/template" id="partial-search-item">
        <div class="col-xs-12 col-sm-6 col-md-4 mix" data-myorder="{{distance}}">
            <div class="panel panel-default card">
                <div class="panel-body">
                    {{#logo}}
                    <img src="{{logo}}" class="img-responsive logo"/>
                    {{/logo}}
                    <h4 class="title">
                        {{title}}<br>
                    </h4>
                    <div class="excerpt">{{{excerpt}}}</div>
                </div>
                <div class="panel-footer text-right">
                    <span class="card-stat"><i class="fa fa-car"></i>&nbsp;{{distance}} KM</span>
                    <button class="btn pill-pricing" type="button" data-post="{{id}}">From £15</button>
                    <button class="btn btn-success btn-get-deal" type="button" data-post="{{id}}">View Deal</button>
                </div>
            </div>
        </div>
    </script>
    <!-- /Template -->

</body>
</html>












