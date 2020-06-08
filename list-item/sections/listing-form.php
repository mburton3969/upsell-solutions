<form action="assets/php/add-item.php" method="post">
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Title:</h4>
                </div>
                <div class="col-md-6">
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
                <div class="col-md-6">
                  <input type="text" id="product_brand" style="width:31%;display:inline;" name="product_brand" class="form-control is-field" placeholder="Brand" onchange="format_ebay();" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_brand'];}?>" required>
                  <input type="text" id="product_material" style="width:31%;display:inline;" name="product_material" class="form-control is-field" placeholder="Material" maxlength="50" onchange="format_ebay();" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_material'];}?>" required>
                  <input type="text" id="product_color" style="width:31%;display:inline;" name="product_color" class="form-control is-field" placeholder="Color" onchange="format_ebay();" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_color'];}?>" required>
                  <label for="product_Size" style="width:31%;">
                    <span id="size_label"></span>
                    <br>
                  <select id="product_Size" name="product_Size" onchange="format_ebay();" style="display:inline;" class="form-control is-field">
                    <option value="">Select a Size</option>
                  <?php
                    $s_conn = mysqli_connect('localhost','outfitte_store','+F%JW[$YDOR(','outfitte_opencart') or die('Error: ' . $s_conn->error . ' on line 4 of add-to-store-api.php');
                    //Juniors...
                    echo '<option value="">****Junior Sizes****</option>';
                    $jsoq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '4' AND `filter_category` = 'Juniors' ORDER BY `name` ASC";
                    $jsog = mysqli_query($s_conn, $jsoq) or die($s_conn->error . 'ERROR');
                    while($jsor = mysqli_fetch_array($jsog)){
                      echo '<option value="' . $jsor['name'] . '">' . $jsor['name'] . '</option>';
                    }
                    //Regular...
                    echo '<option value="">****Regular Sizes****</option>';
                    $rsoq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '4' AND `filter_category` = 'Regular' ORDER BY `name` ASC";
                    $rsog = mysqli_query($s_conn, $rsoq) or die($s_conn->error . 'ERROR');
                    while($rsor = mysqli_fetch_array($rsog)){
                      echo '<option value="' . $rsor['name'] . '">' . $rsor['name'] . '</option>';
                    }
                    //Plus...
                    echo '<option value="">****Plus Sizes****</option>';
                    $plsoq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '4' AND `filter_category` = 'Plus' ORDER BY `name` ASC";
                    $plsog = mysqli_query($s_conn, $plsoq) or die($s_conn->error . 'ERROR');
                    while($plsor = mysqli_fetch_array($plsog)){
                      echo '<option value="' . $plsor['name'] . '">' . $plsor['name'] . '</option>';
                    }
                    //Petite...
                    echo '<option value="">****Petite Sizes****</option>';
                    $psoq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '4' AND `filter_category` = 'Petite' ORDER BY `name` ASC";
                    $psog = mysqli_query($s_conn, $psoq) or die($s_conn->error . 'ERROR');
                    while($psor = mysqli_fetch_array($psog)){
                      echo '<option value="' . $psor['name'] . '">' . $psor['name'] . '</option>';
                    }
                    //Infants/Toddlers...
                    echo '<option value="">****Infant/Toddler Sizes****</option>';
                    $psoq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '4' AND `filter_category` = 'Infant/Toddler' ORDER BY `name` ASC";
                    $psog = mysqli_query($s_conn, $psoq) or die($s_conn->error . 'ERROR');
                    while($psor = mysqli_fetch_array($psog)){
                      echo '<option value="' . $psor['name'] . '">' . $psor['name'] . '</option>';
                    }
                  ?>
                  </select>
                  </label>
                  <!--
                  <input type="text" id="product_Size" style="width:31%;display:inline;" name="product_Size" class="form-control is-field" placeholder="Size" onchange="format_ebay();" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_Size'];}?>" >
                  -->
                  <input type="hidden" id="product_Type" name="product_Type" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_Type'];}?>" />
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
                    <small>Preview: (Actual description may look different on ebay)</small>
                    <div id="desc_preview" class="desc_preview" style="border:1px solid blue;height:400px;background:rgba(0,0,255,0.1);overflow:scroll;" contenteditable="false">
                      
                    </div>
                </div>
                <div class="col-md-6">
                  <!--<input type="text" id="product_description" style="width: 100%;" name="product_description" class="form-control" placeholder="Description" Required>-->
                  <textarea id="product_description" style="width: 100%;height:150px;" name="product_description" class="form-control" placeholder="Description" onchange="format_ebay();" Required><?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_description'];}?></textarea>
                  <textarea id="product_description_extra" style="width: 100%;height:150px;" name="product_description_extra" class="form-control" placeholder="Description Extras" onchange="format_ebay();" Required><?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_description_extra'];}?></textarea>
                  <textarea id="product_description_footer" style="width: 100%;height:150px;" name="product_description_footer" class="form-control" placeholder="Description Footer" onchange="format_ebay();" readonly="readonly" Required>
                    <?php if($_GET['retry'] == 'Yes'){
                            echo $_SESSION['form_data']['product_description_footer'];
                          }else{
                            //echo 'Thank you for shopping with 81 Outfitters. With our top rating and consistently lowest prices, we look forward to exceeding your expectations. ';
                            include 'list-item/templates/description2.php';
                            echo $ebay_description_template;
                          }
                    ?>
                  </textarea>
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
                  <label for="product_price">Ebay Price <input type="text" id="product_price" style="width: 100%;" name="product_price" class="form-control" placeholder="Ebay Price" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['product_price'];}?>" autocomplete="off" Required></label>
                  <label for="website_product_price">Website Price <input type="text" id="website_product_price" style="width: 100%;" name="website_product_price" class="form-control" placeholder="Website Price" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['website_product_price'];}?>" autocomplete="off" Required></label>
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
                <div class="col-md-6">
                  <input type="text" id="product_code" style="width: 100%;" name="product_code" class="form-control" placeholder="UPC Code" value="<?php if($_GET['retry'] == 'Yes'){/*echo $_SESSION['form_data']['product_code'];*/}?>" Required>
                  <button type="button" class="btn btn-warning btn-sm" onclick="document.getElementById('product_code').value = 'Does not apply';">
                    Does not apply
                  </button>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Listing Locations:</h4>
                </div>
                <div class="col-md-6 ">
                  <label class="checkbox-inline">
                    <input type="checkbox" checked data-toggle="toggle" name="submit_to_store" id="submit_to_store" /> 81O-Store
                  </label>
                  <br><br>
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
    <input type="hidden" id="ebay_import" name="ebay_import" value="" />
    <input type="hidden" id="import_ebay_listing" name="import_ebay_listing" value="<?php echo $_REQUEST['import_ebay_listing']; ?>" />
    <div class="text-center">
        <div class="btn-group" role="group" style="margin: 0px;padding: 10px;">
            <!--<button class="btn btn-light btn-lg border rounded-0 shadow-sm" type="button">Cancel</button>-->
            <input type="hidden" name="env_mode" value="PRODUCTION"><!--'SANDBOX' or 'PRODUCTION'-->
            <input type="hidden" name="api_key" value="ScSDadVl4tQLQ2NLMnLpuFbibQGQySNbJZLVKyQvhi1Zmt4u60U72HdqETS0ZRT3mUnr5IN2a14VnEO37kXLxHf40CHmCWuNhiHkdoIrXgYBmvJX1tK87nzlX5dLEji0U11BdhgvpGH0SEXJPHY0HNRSqC8XMphG65tcnxLSj7Ppa6fKgTFdMo6JsQJMO61pS1jTo6A3lKPSQSZYvTD4d6vFTIBD6fepMvh3zHzijSpVG15gVuxgizwetm84vjmQ" />
            
            <button type="submit" id="submit_btn" class="btn btn-success btn-lg text-white border rounded-0 border-dark shadow-sm">Submit</button>
        </div>
    </div>
    <input type="hidden" id="item_specifics_array" name="item_specifics_array" value="<?php if($_GET['retry'] == 'Yes'){echo $_SESSION['form_data']['item_specifics_array'];}?>" />
</form>