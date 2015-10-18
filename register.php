<?php
/**
 * Fields:
 *  - id
 *  - email
 *  - password
 *  - date_of_birth
 *  - formatted_address
 *  - forename
 *  - surname
 */
session_start();
$sql_error = -1;

if(isset($_POST) && !empty($_POST)){
    require_once('db.php');

    if(!isset($_POST['email'])){
        die ("Field 'email' was not found.");
    }
    if(!isset($_POST['password'])){
        die ("Field 'password' was not found.");
    }
    if(!isset($_POST['password2'])){
        die ("Field 'password2' was not found.");
    }
    if($_POST['password'] !== $_POST['password2']){
        die("Passwords do not match each other.");
    }
    if(!isset($_POST['forename'])){
        die ("Field 'forename' was not found.");
    }
    if(!isset($_POST['surname'])){
        die ("Field 'surname' was not found.");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $forename = $_POST['forename'];
    $surname = $_POST['surname'];

    $cost = 10;
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
    $salt = sprintf("$2a$%02d$", $cost) . $salt;
    $hash = crypt($password, $salt);

    $stmt = $db->prepare("INSERT INTO users (email,password,forename,surname,date_of_birth) VALUES (?,?,?,?,?)");
    $stmt->bind_param('sssss',$email,$hash,$forename,$surname,$dob);
    $stmt->execute();
    if($stmt->error){
        $sql_error = $stmt->errno;
    }else{
        Header('Location: /login');
    }
    $stmt->close();
}
?>
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

<form id="create-form" method="POST" class="form" enctype="multipart/form-data">
    <section class="container content-form">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="title">Register</h3>
                <div class="line-center"></div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <legend>Account details</legend>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" class="form-control"
                           value="<?php
                           if($sql_error == 1062) {
                               echo $_POST['email'];
                           }
                           ?>"
                           required/>
                </div>
                <p class="text-danger">
                    <?php
                    if($sql_error == 1062) {
                        echo 'This email address is already in use. <a href="/login">Login here</a>';
                    }
                    ?>
                </p>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" class="form-control" pattern=".{6,}" required title="6 characters minimum"/>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="password2">Repeat password*</label>
                    <input type="password" id="password2" name="password2" placeholder="Enter password again" class="form-control" pattern=".{6,}" required title="6 characters minimum"/>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <legend>About you</legend>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="forename">First name*</label>
                    <input type="text" id="forename" name="forename" placeholder="Enter first name" class="form-control"
                           value="<?php
                           if(isset($_POST['forename'])) {
                               echo $_POST['forename'];
                           }
                           ?>"
                           required/>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="surname">Last name*</label>
                    <input type="text" id="surname" name="surname" placeholder="Enter last name" class="form-control"
                           value="<?php
                           if(isset($_POST['surname'])) {
                               echo $_POST['surname'];
                           }
                           ?>"
                           required/>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="houseId">House number/name*</label>
                    <input type="text" id="houseId" placeholder="Enter house number/name" class="form-control" required/>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="postcode">Postcode*</label>
                    <input type="text" id="postcode" name="postcode" placeholder="Enter postcode" class="form-control" required/>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="dob">Date of birth*</label>
                    <input type="date" id="dob" name="dob" class="form-control"
                           value="<?php
                           if(isset($_POST['dob'])) {
                               echo $_POST['dob'];
                           }
                           ?>"
                           required/>
                </div>
            </div>
            <div class="col-xs-12  col-md-6 col-md-offset-3">
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" required/>
                            Tick to confirm you agree to our <a href="#">Terms</a> and that you have read our <a href="#">Cookie</a> Use.
                        </label>
                    </div>
                </div>
                <button type="submit" id="submit" class="btn btn-lg btn-theme">Register</button>
            </div>
        </div>
    </section>
</form>

<?php include_once('partials/footer.php'); ?>

</body>
</html>