<?php
session_start();
error_reporting(0);
//print_r($_SESSION);
include 'assets/php/connection.php';
$config = require 'assets/php/ebay-config.php';
$maint = 'No';//Site Under Maintenance? Yes or No...
if($maint == 'Yes' && $_GET['bypass'] != 'Yes'){
	header('Location: maintenance.php');
}
$_SESSION['ebay_mode'] = 'production';//sandbox or production
$env_mode = $_SESSION['ebay_mode'];
$_SESSION['ebay_mode_val'] = false;//true="sandbox" false="production"

if($_SESSION['auth_code'] == '' || !isset($_SESSION['auth_code'])){
  if($_SESSION['ebay_mode'] == 'sandbox'){
    $rurl = 'https://auth.sandbox.ebay.com/oauth2/authorize?client_id=' . $config[$env_mode]['credentials']['appId'] . '&response_type=code&redirect_uri=' . $config[$env_mode]['ruName'] . '&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/sell.finances';
    header('Location: '.$rurl);
  }elseif($_SESSION['ebay_mode'] == 'production'){
    $rurl = 'https://auth.ebay.com/oauth2/authorize?client_id=' . $config[$env_mode]['credentials']['appId'] . '&response_type=code&redirect_uri=' . $config[$env_mode]['ruName'] . '&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly';
    header('Location: '.$rurl);
  }else{
    //Error...
    echo 'ERROR';
  }
}
if($_SESSION['user_token'] == '' || !isset($_SESSION['user_token'])){
  if($_SESSION['refresh_token'] == '' || !isset($_SESSION['refresh_token'])){
    $_SESSION['auth_code'] = '';
    echo '<script>
            window.location = "http://' . $_SERVER['HTTP_HOST'] . '";
          </script>';
  }else{
    $trurl = 'assets/php/refresh-token-test.php';
    //header('Location: '.$trurl);
    echo '<script>
            window.location = "' . $trurl . '";
          </script>';
  }
}
$cache_buster = uniqid();

//Check for Previous form-data...
if($_GET['retry'] == 'Yes'){
  //print_r($_SESSION['form_data']);
  //echo $_SESSION['form_data']['product_title'];
  //echo '<br><br>';
  //echo $_SESSION['pd'];
  echo '<script>
          var retry = true;
        </script>';
}
?>
<?php //if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data'][''];}?>
<html>
<head>
	<title>API Test</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />  <link rel="stylesheet" href="assets/css/modal-style.css">
  <link rel="stylesheet" href="assets/css/loader.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <style>
    td{
      padding: 5px;
    }
    .toggle-group .toggle-handle{
      background-color: #fff !important;
      border: 1px solid #000 !important;
    }
    .toggle-group .btn{
      border: 1px solid #000 !important;
    }
    .toggle-group .btn-default{
      color: #333;
      background-color: #e6e6e6;
      border-color: #adadad;
    }
  </style>
</head>
<body onload="get_cats(1);get_store_cats(1,'',25334048017);format_ebay();<?php if($_REQUEST['rety'] != 'Yes'){ echo 'get_81_store_cats(1,\'0\');';} ?>">
  <div id="loader" class="loader" style="display:<?php if($_GET['retry'] == 'Yes'){echo 'inline';}else{echo 'none';} ?>;">Loading...</div>
    <div>
        <div class="container">
          
          <!--Chrome Browser Notification-->
          <div class="row" id="chromeNotification"></div>
          
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center bg-light shadow" style="margin: 8px;padding: 10px;">Product Detail Form <small>[<a href="destroy.php">Refresh Session</a>]</small></h1>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <?php 
                //Scanned BC...
                $dq = "SELECT DISTINCT `upc_code` FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` = 'UPC Scan' AND `date` = CURRENT_DATE";
                $dg = mysqli_query($conn, $dq) or die($conn->error);
                $scanned_bc = mysqli_num_rows($dg);
              
                //Data Found...
                $dq = "SELECT DISTINCT `upc_code`,`data_source` FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` = 'UPC Scan' AND `data_found` = 'Yes' AND `date` = CURRENT_DATE";
                $dg = mysqli_query($conn, $dq) or die($conn->error);
                $bc_data = mysqli_num_rows($dg);
                //Setup API Variables...
                $de_api = 0;
                $bl_api = 0;
                $upc_api = 0;
                $wm_api = 0;
                while($dr = mysqli_fetch_array($dg)){
                  if($dr['data_source'] == 'digit-eyes.com'){
                    $de_api++;
                  }
                  if($dr['data_source'] == 'barcodelookup.com'){
                    $bl_api++;
                  }
                  if($dr['data_source'] == 'upcitemdb.com'){
                    $upc_api++;
                  }
                  if($dr['data_source'] == 'walmart.com'){
                    $wm_api++;
                  }
                }
              
                //Store Listings...
                $sldq = "SELECT * FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` = 'Listing_Store' AND `listed` = 'Yes' AND `date` = CURRENT_DATE";
                $sldg = mysqli_query($conn, $sldq) or die($conn->error);
                $s_listings = mysqli_num_rows($sldg);
              
                //Ebay Listings...
                $eldq = "SELECT * FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` = 'Listing_Ebay' AND `listed` = 'Yes' AND `date` = CURRENT_DATE";
                $eldg = mysqli_query($conn, $eldq) or die($conn->error);
                $e_listings = mysqli_num_rows($eldg);
              
                  echo '<div class="col-md-4 text-center alert alert-info">
                          <h4>Barcodes Scanned:</h4> 
                          <p>' . $scanned_bc . '</p>
                        </div>';
                  
                  echo '<div class="col-md-4 text-center alert alert-info">
                          <h4>Barcodes Found:</h4>
                          <p>' . $bc_data . '</p>
                        </div>';
                        
                  echo '<div class="col-md-4 text-center alert alert-info">
                          <h4>Items Listed:</h4>
                          <p>81O Store: ' . $s_listings . '</p>
                          <p>Ebay Store: ' . $e_listings . '</p>
                        </div>';
              
                if($_GET['dev'] == 'Yes'){
                  echo '<div class="col-md-3 text-center alert alert-info">
                          <h5><u>Barcodes Scanned:</u></h5> 
                          <p>' . $scanned_bc . '</p>
                        </div>';
                  
                  echo '<div class="col-md-3 text-center alert alert-info">
                          <h5><u>Barcodes Found:</u></h5>
                          <p>' . $bc_data . '</p>
                        </div>';
                        
                  echo '<div class="col-md-3 text-center alert alert-info">
                          <h5><u>Items Listed:</u></h5>
                          <p>' . $listings . '</p>
                        </div>';
                  
                  echo '<div class="col-md-3 alert alert-info">
                          <h5 class="text-center"><u>API Usage:</u></h5>
                          <table>
                            <tr><td>Digit-Eyes API: </td><td>' . $de_api . '</td></tr>
                            <tr><td>Barcode Lookup API: </td><td>' . $bl_api . '</td></tr>
                            <tr><td>UPC Item DB API: </td><td>' . $upc_api . '</td></tr>
                            <tr><td>Walmart API: </td><td>' . $wm_api . '</td></tr>
                          </table>
                        </div>';
                }
              
                ?>
            </div>
        </div>
      <br>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <input class="border rounded border-dark form-control-lg" type="text" style="width:100%;margin:2px;" placeholder="Scan UPC Code Here" id="upc_code" name="upc_code" onkeyup="lookup_upc(event,this.value);">
                    <p style="color:red;font-weight:bold;" id="response_message"></p>
                </div>
            </div>
        </div>
    </div>
    <br>

<form action="assets/php/add-item.php" method="post">
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Title:</h4>
                </div>
                <div class="col">
                  <input type="text" id="product_title" style="width: 100%;" name="product_title" class="form-control" placeholder="Title" maxlength="80" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_title'];}?>" onchange="format_ebay();" Required>
                  <p id="product_title_display"></p>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Ebay Category:
                    	<select class="form-control" id="product_section" name="product_section" style="float:right;width:50%;" onchange="format_ebay();" required>
                    		<option value="">Select Section</option>
                    		<option value="Mens" <?php if($_GET['retry'] == 'Yes' && $_SESSION['form_data']['product_section'] == 'Mens'){echo 'selected';}?>>Mens</option>
                    		<option value="Womens" <?php if($_GET['retry'] == 'Yes' && $_SESSION['form_data']['product_section'] == 'Womens'){echo 'selected';}?>>Womens</option>
                    		<option value="Childrens" <?php if($_GET['retry'] == 'Yes' && $_SESSION['form_data']['product_section'] == 'Childrens'){echo 'selected';}?>>Childrens</option>
                    	</select>
                    </h4>
                </div>
                <div class="col-md-6" id="cat_box">
                  <select id="product_category" name="product_category" class="form-control" Required>
                    <option value="">Select Ebay Category</option>
                  </select>
              </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">
                      Item Specifics:
                      <button type="button" id="add_specific" style="width:30%;display:inline;float:right;" name="add_specific" class="form-control btn btn-primary" onclick="new_specific();"><i class="fas fa-plus"></i> Add Specific</button>
                    </h4>
                </div>
                <div class="col">
                  <input type="text" id="product_brand" style="width:31%;display:inline;" name="product_brand" class="form-control is-field" placeholder="Brand" onchange="format_ebay();" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_brand'];}?>" required>
                  <input type="text" id="product_material" style="width:31%;display:inline;" name="product_material" class="form-control is-field" placeholder="Material" maxlength="50" onchange="format_ebay();" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_material'];}?>" required>
                  <input type="text" id="product_color" style="width:31%;display:inline;" name="product_color" class="form-control is-field" placeholder="Color" onchange="format_ebay();" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_color'];}?>" required>
                  <input type="text" id="product_Size" style="width:31%;display:inline;" name="product_Size" class="form-control is-field" placeholder="Size" onchange="format_ebay();" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_Size'];}?>" >
                  <span id="item_specifics"></span>
                  <!--
                  <input type="text" id="product_color" style="width: 32%;display:inline;" name="product_color" class="form-control" placeholder="Color">
                  <input type="text" id="product_sizetype" style="width: 32%;display:inline;" name="product_sizetype" class="form-control" placeholder="Size Type">
                  <input type="text" id="product_style" style="width: 32%;display:inline;" name="product_style" class="form-control" placeholder="Style">
                  <input type="text" id="product_sleevelength" style="width: 32%;display:inline;" name="product_sleevelength" class="form-control" placeholder="Sleeve Length">
                  -->
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Description:</h4>
                    <small>Preview:</small>
                    <div id="desc_preview" class="desc_preview" style="border:1px solid blue;height:400px;background:rgba(0,0,255,0.1);overflow:scroll;" contenteditable="false">
                      
                    </div>
                </div>
                <div class="col">
                  <!--<input type="text" id="product_description" style="width: 100%;" name="product_description" class="form-control" placeholder="Description" Required>-->
                  <textarea id="product_description" style="width: 100%;height:150px;" name="product_description" class="form-control" placeholder="Description" onchange="format_ebay();" Required><?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_description'];}?></textarea>
                  <textarea id="product_description_extra" style="width: 100%;height:150px;" name="product_description_extra" class="form-control" placeholder="Description Extras" onchange="format_ebay();" Required><?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_description_extra'];}?></textarea>
                  <textarea id="product_description_footer" style="width: 100%;height:150px;" name="product_description_footer" class="form-control" placeholder="Description Footer" onchange="format_ebay();" Required><?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_description_footer'];}else{echo 'Thank you for shopping with 81 Outfitters. With our top rating and consistently lowest prices, we look forward to exceeding your expectations. ';}?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Condition:</h4>
                </div>
                <div class="col-md-6">
                  <select id="product_condition" style="width: 100%;" name="product_condition" class="form-control" Required>
                    <option value="">Select Condition</option>
                    <option value="1000" selected>New with tags/box</option>
                    <option value="1500">New without tags/box</option>
                    <option value="1750">New with defects</option>
                    <option value="3000">Pre-owned</option>
                  </select>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Images: <small>[Click Image to Remove]</small></h4>
                    <div class="text-left">
                        <!--<input class="btn btn-primary text-center text-body bg-light border rounded border-dark shadow-sm" type="file" value="Upload">-->
                        <input type="text" name="new_img_url" id="new_img_url" class="form-control" placeholder="New Image URL" />
                        <button type="button" class="btn btn-success text-center text-body border rounded shadow-sm" onclick="add_item_img();">
                          <i class="fas fa-plus"></i> Add Image
                        </button>
                        <button type="button" class="btn btn-primary text-center text-body border rounded shadow-sm" onclick="document.getElementById('new_img_url').value = '';" data-toggle="modal" data-target="#imageUploadModal">
                          <i class="fas fa-upload"></i> Upload Image From File
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                  <a id="img1_link" href="#" onclick="remove_item_img('1');return false;" target="_blank"><img id="product_image1" name="product_image1" style="width: 32%;padding:5px;" draggable="true" ondragstart="drag(event,this);" ondrop="drop(event,this);" ondragover="allowDrop(event);" <?php if($_GET['retry'] == 'Yes' && $_SESSION['form_data']['img_url1'] != ''){echo 'src="' . $_SESSION['form_data']['img_url1'] . '"';}else{/*echo 'src="https://via.placeholder.com/150"';*/}?>></a>
                    <input type="hidden" id="img_url1" name="img_url1" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['img_url1'];}?>" />
                  <a id="img2_link" href="#" onclick="remove_item_img('2');return false;" target="_blank"><img id="product_image2" name="product_image2" style="width: 32%;padding:5px;" draggable="true" ondragstart="drag(event,this);" ondrop="drop(event,this);" ondragover="allowDrop(event);" <?php if($_GET['retry'] == 'Yes' && $_SESSION['form_data']['img_url2'] != ''){echo 'src="' . $_SESSION['form_data']['img_url2'] . '"';}else{/*echo 'src="https://via.placeholder.com/150"';*/}?>></a>
                    <input type="hidden" id="img_url2" name="img_url2" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['img_url2'];}?>" />
                  <a id="img3_link" href="#" onclick="remove_item_img('3');return false;" target="_blank"><img id="product_image3" name="product_image3" style="width: 32%;padding:5px;" draggable="true" ondragstart="drag(event,this);" ondrop="drop(event,this);" ondragover="allowDrop(event);" <?php if($_GET['retry'] == 'Yes' && $_SESSION['form_data']['img_url3'] != ''){echo 'src="' . $_SESSION['form_data']['img_url3'] . '"';}else{/*echo 'src="https://via.placeholder.com/150"';*/}?>></a>
                    <input type="hidden" id="img_url3" name="img_url3" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['img_url3'];}?>" />
                  <a id="img4_link" href="#" onclick="remove_item_img('4');return false;" target="_blank"><img id="product_image4" name="product_image4" style="width: 32%;padding:5px;" draggable="true" ondragstart="drag(event,this);" ondrop="drop(event,this);" ondragover="allowDrop(event);" <?php if($_GET['retry'] == 'Yes' && $_SESSION['form_data']['img_url4'] != ''){echo 'src="' . $_SESSION['form_data']['img_url4'] . '"';}else{/*echo 'src="https://via.placeholder.com/150"';*/}?>></a>
                    <input type="hidden" id="img_url4" name="img_url4" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['img_url4'];}?>" />
                  <a id="img5_link" href="#" onclick="remove_item_img('5');return false;" target="_blank"><img id="product_image5" name="product_image5" style="width: 32%;padding:5px;" draggable="true" ondragstart="drag(event,this);" ondrop="drop(event,this);" ondragover="allowDrop(event);" <?php if($_GET['retry'] == 'Yes' && $_SESSION['form_data']['img_url5'] != ''){echo 'src="' . $_SESSION['form_data']['img_url5'] . '"';}else{/*echo 'src="https://via.placeholder.com/150"';*/}?>></a>
                    <input type="hidden" id="img_url5" name="img_url5" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['img_url5'];}?>" />
                </div>
            </div>
        </div>
    </div>
    <div style="background:#8A8A8A;">
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Ebay Store Category: <!--<small style="color:red;font-weight:bold;">[Not Yet Working]</small>--></h4>
                </div>
                <div class="col-md-6" id="store_cat_box">
                  <select id="product_store_category" name="product_store_category" class="form-control" onmouseover="sortSelect(this);" Required>
                    <option value="">Select Store Category</option>
                  </select>
              </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">81O Store Category: <!--<small style="color:red;font-weight:bold;">[Not Yet Working]</small>--></h4>
                </div>
                <div class="col-md-6" id="81_store_cat_box">
                  <select id="product_81_store_category" name="product_81_store_category" class="form-control" Required>
                    <option value="">Select 81O Store Category</option>
                  </select>
              </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Custom Label:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_label" style="width: 100%;" name="product_label" class="form-control" placeholder="Custom Label" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_label'];}?>" Required></div>
            </div>
        </div>
    </div>
  </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Price:</h4>
                </div>
                <div class="col-md-6">
                  <input type="text" id="product_price" style="width: 100%;" name="product_price" class="form-control" placeholder="Price" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_price'];}?>" Required>
                  <span id="suggested_prices"></span>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Quantity:</h4>
                </div>
                <div class="col-md-6"><input type="number" id="product_quantity" style="width: 100%;" name="product_quantity" class="form-control" placeholder="Quantity" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_quantity'];}?>" Required></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Package Weight:</h4>
                </div>
                <div class="col-md-6">
                  <input type="number" style="width: 49%;display:inline;" id="product_pkg_lbs" name="product_pkg_lbs" class="form-control" placeholder="Pounds" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_pkg_lbs'];}?>" Required>
                  <input type="number" style="width: 49%;display:inline;" id="product_pkg_oz" name="product_pkg_oz" class="form-control" placeholder="Ounces" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_pkg_oz'];}?>" Required>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">UPC Code:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_code" style="width: 100%;" name="product_code" class="form-control" placeholder="UPC Code" value="<?php if($_GET['retry'] == 'Yes'){/*echo $_SESSION['form_data']['product_code'];*/}?>" Required></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Listing Locations:</h4>
                </div>
                <div class="col-md-6 ml-15">
                  <label class="checkbox-inline">
                    <input type="checkbox" checked data-toggle="toggle" name="submit_to_store" id="submit_to_store" /> 81O-Store
                  </label>
                  <br>
                  <label class="checkbox-inline">
                    <input type="checkbox" checked data-toggle="toggle" name="submit_to_ebay" id="submit_to_ebay" /> Ebay Store
                  </label>
                </div>
            </div>
        </div>
    </div>
  <br>
    <input type="hidden" id="cur_cat" name="cur_cat" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['cur_cat'];}?>" />
    <input type="hidden" id="cur_store_cat" name="cur_store_cat" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['cur_store_cat'];}?>" />
    <input type="hidden" id="cur_81_cat" name="cur_81_cat" value="" />
    <div class="text-center">
        <div class="btn-group" role="group" style="margin: 0px;padding: 10px;">
            <!--<button class="btn btn-light btn-lg border rounded-0 shadow-sm" type="button">Cancel</button>-->
            <input type="hidden" name="env_mode" value="PRODUCTION"><!--'SANDBOX' or 'PRODUCTION'-->
            <input type="hidden" name="api_key" value="ScSDadVl4tQLQ2NLMnLpuFbibQGQySNbJZLVKyQvhi1Zmt4u60U72HdqETS0ZRT3mUnr5IN2a14VnEO37kXLxHf40CHmCWuNhiHkdoIrXgYBmvJX1tK87nzlX5dLEji0U11BdhgvpGH0SEXJPHY0HNRSqC8XMphG65tcnxLSj7Ppa6fKgTFdMo6JsQJMO61pS1jTo6A3lKPSQSZYvTD4d6vFTIBD6fepMvh3zHzijSpVG15gVuxgizwetm84vjmQ" />
            <?php ?>
            <button type="submit" id="submit_btn" class="btn btn-success btn-lg text-white border rounded-0 border-dark shadow-sm">Submit To Ebay</button>
        </div>
    </div>
    <input type="hidden" id="item_specifics_array" name="item_specifics_array" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['item_specifics_array'];}?>" />
</form>
  
<!-- Footer -->
  <p style="text-align:center;">&copy; Reseller Solutions <i class="fa fa-code-branch"> V2.7.1</i> | Developed By <a href="http://ignition-innovations.com" target="_blank">Ignition Innovations</a></p>
    <br>
  <?php include 'list-item/modals/success-modal.php'; ?>
  <?php include 'list-item/modals/error-modal.php'; ?>
  <?php include 'list-item/modals/img-upload-modal.php'; ?>
</body>
<script src="assets/js/item-specifics-functions.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/upc-lookup-api.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/upc-parsers.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/errors.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/chrome-detection.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/get-categories.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/img-handler.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/item-price-functions.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/product-img-uploader.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/formatting-functions.js?cb=<?php echo $cache_buster; ?>"></script>
<?php
  if($_GET['res_code'] == 204){
    echo '<script>
          $("#successModal").modal("show");
          </script>';
  }
  
  if($_GET['retry'] == 'Yes'){
    
    echo '<script>';
    echo '(function(){';
    echo 'document.getElementById("loader").style.display = "inline";';
    //eBay Categories...
    $timer = 500;
    $clvl = 1;
    if(isset($_SESSION['form_data']['product_category_2']) && $_SESSION['form_data']['product_category_2'] != ''){
      echo 'setTimeout(function(){get_cats(2,' . $_SESSION['form_data']['product_category_1'] . ',"' . $_SESSION['form_data']['product_category_2'] . '");
      document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_2'] . '";},' . $timer . ');
      console.log("Cat2");';
      $timer = $timer + 500;
      $clvl = 2;
    }
    if(isset($_SESSION['form_data']['product_category_3']) && $_SESSION['form_data']['product_category_3'] != ''){
      echo 'setTimeout(function(){get_cats(3,' . $_SESSION['form_data']['product_category_2'] . ',"' . $_SESSION['form_data']['product_category_3'] . '");
      document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_3'] . '";},' . $timer . ');
      console.log("Cat3");';
      $timer = $timer + 500;
      $clvl = 3;
    }
    if(isset($_SESSION['form_data']['product_category_4']) && $_SESSION['form_data']['product_category_4'] != ''){
      echo 'setTimeout(function(){get_cats(4,' . $_SESSION['form_data']['product_category_3'] . ',"' . $_SESSION['form_data']['product_category_4'] . '");
      document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_4'] . '";},' . $timer . ');
      console.log("Cat4");';
      $timer = $timer + 500;
      $clvl = 4;
    }
    if(isset($_SESSION['form_data']['product_category_5']) && $_SESSION['form_data']['product_category_5'] != ''){
      echo 'setTimeout(function(){get_cats(5,' . $_SESSION['form_data']['product_category_4'] . ',"' . $_SESSION['form_data']['product_category_5'] . '");
      document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_5'] . '";},' . $timer . ');
      console.log("Cat5");';
      $timer = $timer + 500;
      $clvl = 5;
    }
    
    echo 'setTimeout(function(){
            //var nCatLevel = catLevel + 1;
            var cl = document.getElementById("product_category_' . $clvl . '").value;
            getItemSpecifics(cl);
            document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_'.$clvl] . '";
            console.log("clvl: "+cl);
          },' . ($timer + 1500) . ');
          ';
    
    //Item Specifics...
    $isa = explode(',',$_SESSION['form_data']['item_specifics_array']);
    echo 'setTimeout(function(){';
    foreach($isa as $is){
      //echo 'new_specific("' . $is . '","Bypass");';
      echo 'document.getElementById("product_' . $is . '").value = "' . $_SESSION['form_data']['product_' . $is] . '";';
      
    }
    echo '},' . ($timer + 4000) . ');';
    
    //Store Categories...
    echo 'setTimeout(function(){document.getElementById("product_store_category_1").value = "' . $_SESSION['form_data']['product_store_category_1'] . '";},' . ($timer + 4500) . ');
    ';
    $stimer = 0;
    $sclvl = 0;
    if(isset($_SESSION['form_data']['product_category_2']) && $_SESSION['form_data']['product_store_category_2'] != ''){
      echo 'setTimeout(function(){get_store_cats(2,' . $_SESSION['form_data']['product_store_category_1'] . ',"' . $_SESSION['form_data']['product_store_category_2'] . '");},750);
      console.log("StoreCat2");';
      $stimer = $stimer + 2500;
      $sclvl = 1;
      echo 'setTimeout(function(){
              document.getElementById("product_store_category_2").value = "' . $_SESSION['form_data']['product_store_category_2'] . '";
              document.getElementById("cur_store_cat").value = "' . $_SESSION['form_data']['product_store_category_2'] . '";
            },' . $stimer . ');';
    }
    
    
    //81 Store Cat 1...
    if(isset($_SESSION['form_data']['product_81_store_category_1']) && $_SESSION['form_data']['product_81_store_category_1'] != ''){
      echo 'console.warn("81 Store Category 1: ' . $_SESSION['form_data']['product_81_store_category_1'] . '");';
      echo 'setTimeout(function(){get_81_store_cats(1,"0","' . $_SESSION['form_data']['product_81_store_category_1'] . '");
      document.getElementById("cur_81_cat").value = "' . $_SESSION['form_data']['product_81_store_category_1'] . '";},' . $timer . ');
      console.log("81StoreCat1");';
      $timer = $timer + 500;
    }
    //81 Store Cat 2...
    if(isset($_SESSION['form_data']['product_81_store_category_2']) && $_SESSION['form_data']['product_81_store_category_2'] != ''){
      echo 'console.warn("81 Store Category 2: ' . $_SESSION['form_data']['product_81_store_category_2'] . '");';
      echo 'setTimeout(function(){get_81_store_cats(2,"' . $_SESSION['form_data']['product_81_store_category_1'] . '","' . $_SESSION['form_data']['product_81_store_category_2'] . '");
      document.getElementById("cur_81_cat").value = "' . $_SESSION['form_data']['product_81_store_category_2'] . '";
      document.getElementById("loader").style.display = "none";},' . $timer . ');
      console.log("81StoreCat2");';
      $timer = $timer + 500;
    }
    
    echo 'setTimeout(function(){
            document.getElementById("loader").style.display = "none";
          },' . $timer . ');';
    
    echo '})();';
    echo '</script>';
  }
  
  if($_REQUEST['upc_code'] != ''){
    echo '<script>
            (function(){
              lookup_upc(\'BYPASS\',\'' . $_REQUEST['upc_code'] . '\');
            })();
          </script>';
  }
?>
</html>

