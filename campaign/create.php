<?php
// Start Session
session_start();

/**
 * 4 Stages:
 *  1. Get title
 *  2. Get location
 *  3. Get details
 *  4. Submit
 */

$stage = isset($_GET['stage']) ? $_GET['stage'] : 1;

// If stage doesn't exist, treat form as pristine
if(!isset($_GET['stage'])){
    unsetAll();
}

// Stage 1
if($stage <= 1){
    if (isset($_POST['title']) and isset($_POST['type'])) {
        $_SESSION['campaign_title'] = $_POST['title'];
        $_SESSION['campaign_type'] = $_POST['type'];
        nextStage();
    }
}
if($stage == 2){
    if (isset($_POST['houseId']) and isset($_POST['postcode']) and isset($_POST['address']) and isset($_POST['latlng'])) {
        $_SESSION['campaign_houseId'] = $_POST['houseId'];
        $_SESSION['campaign_postcode'] = $_POST['postcode'];
        $_SESSION['campaign_address'] = $_POST['address'];
        $_SESSION['campaign_latlng'] = $_POST['latlng'];
        nextStage();
    }
}
if($stage == 3){
    if (isset($_POST['logo']) and isset($_POST['excerpt']) and isset($_POST['description'])) {
        $_SESSION['campaign_logo'] = $_POST['logo'];
        $_SESSION['campaign_excerpt'] = $_POST['excerpt'];
        $_SESSION['campaign_description'] = $_POST['description'];
        nextStage();
    }
}
if($stage >= 4){
    if (isset($_POST['submit'])) {
        createCampaign();
    }
}

/**
 * Iterates the campaign stage
 */
function nextStage(){
    global $stage;
    if($stage < 1){$stage = 1;}
    if($stage > 4){$stage = 4;}
    $stage++;
    Header('Location: ?stage='.$stage);
}
/**
 * Unset all session variables belonging to the campaign namespace
 */
function unsetAll(){
    unset($_SESSION['campaign_title']);
    unset($_SESSION['campaign_description']);
    unset($_SESSION['campaign_type']);
    unset($_SESSION['campaign_logo']);
    unset($_SESSION['campaign_latlng']);
    unset($_SESSION['campaign_postcode']);
    unset($_SESSION['campaign_address']);
    unset($_SESSION['campaign_excerpt']);
    unset($_SESSION['campaign_houseId']);
}
/**
 * Creates a campaign
 */
function createCampaign(){
    include_once('../db.php');

    // Gather all data
    $owner = $_SESSION['user_id'];
    $title = $_SESSION['campaign_title'];
    $excerpt = $_SESSION['campaign_excerpt'];
    $description = $_SESSION['campaign_description'];
    $type = $_SESSION['campaign_type'];
    $website = '';
    $logo = $_SESSION['campaign_logo'];
    $voucher = '';
    $latlng = $_SESSION['campaign_latlng'];
    $postcode = $_SESSION['campaign_postcode'];
    $address = $_SESSION['campaign_address'];

    // Prepare SQL
    $bindParamStr = 'isssissssss';
    $stmt = $db->prepare("INSERT INTO adverts (owner,title,excerpt,description,type,voucher_code,website,latlng,logo,formatted_address,postcode) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param($bindParamStr,
        $owner,
        $title,
        $excerpt,
        $description,
        $type,
        $voucher,
        $website,
        $latlng,
        $logo,
        $address,
        $postcode
        );

    // Execute Query
    $stmt->execute();

    // Check Campaign was created
    if($stmt->error){
        echo $stmt->errno.': '.$stmt->error;
    }else{
        Header('Location: index?location='.$stmt->insert_id);
    }

    // Close DB
    $stmt->close();

    // Unset
    unsetAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Discover</title>

    <link rel="stylesheet" href="/css/bootstrap.css"/>
    <link rel="stylesheet" href="/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/css/bootstrap-editable.css"/>
    <link rel="stylesheet" href="/css/ionicons.css"/>
    <link rel="stylesheet" href="/css/quill.base.css"/>
    <link rel="stylesheet" href="/css/quill.snow.css"/>
    <link rel="stylesheet" href="/css/discover.css"/>

    <script src="/vendor/jquery-1.11.1.min.js"></script>
    <script src="/vendor/bootstrap.js"></script>
    <script src="/vendor/quill.min.js"></script>
    <script src="/js/LocationEngine.js"></script>
    <script src="/js/common.js"></script>
    <script src="/js/create.js"></script>

</head>
<body>
<?php
if(isset($_SESSION["user_id"])){
    include_once('../partials/navbar_member.php');
}else{
    include_once('../partials/navbar.php');
}
?>

<? if ($stage == 1): ?>
    <form id="create-form" method="POST" class="form" enctype="multipart/form-data">
        <section class="container content-form">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="title">Create your campaign</h3>

                    <div class="line-center"></div>
                </div>

                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="title">Title*</label>
                        <input type="text" id="title" name="title" placeholder="Enter campaign title"
                               class="form-control" required
                               value="<?php echo isset($_SESSION['campaign_title']) ? $_SESSION['campaign_title'] : ''; ?>"/>
                    </div>
                </div>

                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="type">Type*</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="1">Standard</option>
                            <option value="2">Promotion</option>
                            <option value="3">Special Offer</option>
                            <option value="4">Limited Offer</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <button type="submit" id="submit" class="btn btn-lg btn-theme">Create</button>
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <?php //print_r($_SESSION) ?>
                </div>
            </div>
        </section>
    </form>
<?php endif ?>

<?php if($stage == 2): ?>
    <form id="create-form" method="POST" class="form" enctype="multipart/form-data">
        <section class="container content-form">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="title">Campaign Location</h3>
                    <div class="line-center"></div>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="houseId">Building number/name*</label>
                        <input type="text" id="houseId" name="houseId" placeholder="Enter building number/name" class="form-control"
                               value="<?php echo isset($_SESSION['campaign_houseId']) ? $_SESSION['campaign_houseId']:''; ?>"
                               required/>
                    </div>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="postcode">Postcode*</label>
                        <input type="text" id="postcode" name="postcode" placeholder="Enter postcode" class="form-control"
                               value="<?php echo isset($_SESSION['campaign_postcode']) ? $_SESSION['campaign_postcode']:''; ?>"
                               required/>
                    </div>
                    <p class="text-danger"></p>
                </div>
                <div id="full-address" class="col-xs-12 col-md-10 col-md-offset-1
            <?php echo isset($_SESSION['campaign_address']) ? '':'hidden'; ?>
            ">
                    <div class="form-group">
                        <label for="address">Full address*</label>
                        <input type="text" id="address" name="address" placeholder="Enter full address" class="form-control"
                               value="<?php echo isset($_SESSION['campaign_address']) ? $_SESSION['campaign_address']:''; ?>"
                               required/>
                        <input type="text" id="latlng" name="latlng" class="hidden"
                               value="<?php echo isset($_SESSION['campaign_latlng']) ? $_SESSION['campaign_latlng']:''; ?>"
                               required/>
                    </div>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <button id="lookup-address" type="button" class="btn btn-theme">Address Lookup</button>
                    </div>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <button type="submit" id="submit" class="btn btn-lg btn-theme">Next</button>
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <?php //print_r($_SESSION)?>
                </div>
            </div>
        </section>
    </form>
<?php endif ?>

<?php if($stage == 3): ?>
    <form id="create-form" method="POST" class="form" enctype="multipart/form-data">
        <section class="container content-form">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="title">Campaign Details</h3>
                    <div class="line-center"></div>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="excerpt">Excerpt*</label>
                        <input id="excerpt" name="excerpt" maxlength="250" placeholder="Enter excerpt" class="form-control" required/>
                    </div>
                    <p class="help-block">Max 250 characters.</p>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="description">Campaign*</label>
                    <textarea id="description" name="description" placeholder="Enter description" class="form-control hidden" required>
                        <?php echo isset($_SESSION['campaign_description']) ? htmlspecialchars_decode($_SESSION['campaign_description']):''; ?>
                    </textarea>
                        <div class="quill-wrapper">
                            <div id="toolbar" class="toolbar ql-toolbar ql-snow">
                            <span class="ql-format-group">
                                <select class="ql-font">
                                    <option value="sans-serif" selected>Sans-serif</option>
                                    <option value="serif">Serif</option>
                                    <option value="monospace">Monospace</option>
                                </select>
                                <select class="ql-size">
                                    <option value="12px">Small</option>
                                    <option value="14px" selected>Normal</option>
                                    <option value="18px">Large</option>
                                    <option value="32px">Huge</option>
                                </select>
                            </span>
                            <span class="ql-format-group">
                                <span title="Bold" class="ql-format-button ql-bold"></span>
                                <span class="ql-format-separator"></span>
                                <span title="Italic" class="ql-format-button ql-italic"></span>
                                <span class="ql-format-separator"></span>
                                <span title="Underline" class="ql-format-button ql-underline"></span>
                                <span class="ql-format-separator"></span>
                                <span title="Strikethrough" class="ql-format-button ql-strike"></span>
                                <span class="ql-format-separator"></span>
                                <span title="Link" class="ql-format-button ql-link"></span>
                            </span>
                            <span class="ql-format-group">
                                <span title="List" class="ql-format-button ql-list"></span>
                                <span class="ql-format-separator"></span>
                                <span title="Bullet" class="ql-format-button ql-bullet"></span>
                            </span>
                            </div>
                            <div id="editor" class="text-editor">
                                <?php echo isset($_SESSION['campaign_description']) ? htmlspecialchars_decode($_SESSION['campaign_description']):''; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="logo">Logo*</label>
                        <input type="file" accept="image/jpeg,image/png" id="logoInput" value="C:\fakepath\music.jpg" class="form-control" required/>
                        <input type="text" id="logo" name="logo" hidden/>
                    </div>
                    <p class="help-block">Please use .png or .jpg images. Max size: 1MB.</p>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="tag">Tags*</label>
                        <input type="text" id="tag" name="tag" placeholder="Enter tags" class="form-control"/>
                    </div>
                    <p class="help-block">
                        Separate tags with a comma: Food, Takeaway, Chinese
                    </p>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <button type="submit" id="submit" class="btn btn-lg btn-theme">Next</button>
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <?php //print_r($_SESSION)?>
                </div>
            </div>
        </section>
    </form>
    <script>
        var quill = new Quill('#editor',{
            theme: 'snow'
        });
        quill.addModule('toolbar', { container: '#toolbar' });
        quill.on('text-change', function(delta, source) {
            $('#description').val(quill.getHTML());
        });
    </script>
<?php endif ?>

<?php if($stage == 4): ?>
    <form id="create-form" method="POST" class="form" enctype="multipart/form-data">
        <section class="container content-form">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="title">Select package</h3>
                    <div class="line-center"></div>
                </div>
            </div>
            <div class="row content-pricing-table">
                <div class="col-md-3 hidden-sm">
                    <div class="column-odd">
                        <div class="table-row row-title">Product Title</div>
                        <div class="table-row row-title">Clicks</div>
                        <div class="table-row row-title">Support</div>
                        <div class="table-row row-title">&nbsp;</div>
                        <div class="table-row row-title no-border">&nbsp;</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="column-even">
                        <div class="table-row">Charity</div>
                        <div class="table-row">5000</div>
                        <div class="table-row">Yes</div>
                        <div class="table-row row-price">£0.00</div>
                        <div class="table-row no-border">
                            <button type="button" class="btn btn-theme">SELECT</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="column-odd">
                        <div class="table-row">Premium</div>
                        <div class="table-row">Unlimited</div>
                        <div class="table-row">Yes</div>
                        <div class="table-row row-price">£0.10</div>
                        <div class="table-row no-border">
                            <button type="button" class="btn btn-theme">SELECT</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="column-even">
                        <div class="table-row">Business</div>
                        <div class="table-row">Unlimited</div>
                        <div class="table-row">Yes</div>
                        <div class="table-row row-price">£0.15</div>
                        <div class="table-row no-border">
                            <button type="button" class="btn btn-theme">SELECT</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input name="submit" type="checkbox" required/>
                                Tick to confirm you agree to our <a href="#">Terms</a> and that you have read our <a href="#">Cookie</a> Use.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <button type="button" id="preview" class="btn btn-lg btn-theme">Preview</button>
                    <button type="submit" id="submit" class="btn btn-lg btn-theme">Finish</button>
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <?php //print_r($_SESSION)?>
                </div>
            </div>
        </section>
    </form>
<?php endif ?>

<?php include_once('../partials/footer.php'); ?>

</body>
</html>