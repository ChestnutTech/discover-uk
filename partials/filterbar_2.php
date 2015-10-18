<section class="container-full bg-white">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="near-to">
                    <span>Showing </span>
                    <span id="amount">20</span>
                    <span> promotions within </span>
                    <span id="range"></span>
                    <i class="icon ion-loading-c"></i>
                    <span>km of</span>
                    <span id="location"></span>
                    <i class="icon ion-loading-c"></i>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="near-to text-right">
                    <span><?php
                    if(isset($_SESSION["user_forename"])){
                        echo 'Welcome, ' . $_SESSION["user_forename"] . ' ' . $_SESSION['user_surname'] .'.';
                    }
                    ?></span>
                </div>
            </div>
        </div>
    </div>
</section>