<?php
session_start();
$error = -1;

if(isset($_POST) && !empty($_POST)){
    require_once('db.php');

    if(!isset($_POST['email'])){
        die ("Field 'email' was not found.");
    }
    if(!isset($_POST['password'])){
        die ("Field 'password' was not found.");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id,forename,surname,password,isPartner FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $stmt->bind_result($id,$forename,$surname,$hash,$isPartner);

    if($stmt->num_rows == 0){
        $error = 0;
    }

    while($stmt->fetch()) {
        if (hash_equals($hash, crypt($password, $hash))) {
            $_SESSION["user_id"] = $id;
            $_SESSION["user_forename"] = $forename;
            $_SESSION['user_surname'] = $surname;
            $_SESSION['user_isPartner'] = $isPartner;

            // Check if after command exists
            if(isset($_GET['after'])){
                Header('Location: /' . $_GET['after']);
            }else {
                Header('Location: /');
            }
            $stmt->close();
            exit;
        }else{
            $error = 1;
        }
    }
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

<form id="create-form" method="POST" class="form" enctype="multipart/form-data">
    <section class="container content-form">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="title">Login</h3>
                <div class="line-center"></div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="text" id="email" name="email" placeholder="Enter email address" class="form-control" value="<?php if($error == 1){print $_POST['email'];} ?>" required/>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" class="form-control" pattern=".{6,}" required title="6 characters minimum"/>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <p class="text-danger">
                    <?php
                    if($error == 0){
                        print 'Unfortunetly, we have no record of this account.';
                    }else if($error == 1){
                        print 'Email or password is incorrect.';
                    }
                    ?>
                </p>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <button type="submit" id="submit" class="btn btn-lg btn-theme">Login</button>
                <br>
                <br>
                <p><label>Don't have an account? <a href="/register">Sign up now!</a></label></p>
                <p><label>Forgot your password? <a href="/">Recover password</a></label></p>
            </div>
        </div>
    </section>
</form>

<?php include_once('partials/footer.php'); ?>

</body>
</html>