<?php
error_reporting(0);
//Database Connection...
$s_conn = mysqli_connect('localhost','outfitte_store','+F%JW[$YDOR(','outfitte_opencart') or die('Error: ' . $s_conn->error . ' on line 4 of add-to-store-api.php');

//Load Variables...
$api_key = mysqli_real_escape_string($s_conn, $_REQUEST['api_key']);

//Check API Key for Validity...
$aq = "SELECT * FROM `oc_api` WHERE `key` = '" . $api_key . "'";
$ag = mysqli_query($s_conn, $aq) or die($s_conn->error . ' on line 11 of add-to-store-api.php');
if(mysqli_num_rows($ag) <= 0){
  
  $x->status = 'ERROR';
  $x->message = 'API Key Invalid...';
  
}else{
  $x->response = 'GOOD';
  //Check if product UPC Exists in Database...
  $cq = "SELECT * FROM `oc_product` WHERE `upc` = '" . mysqli_real_escape_string($s_conn,$product_code) . "'";
  $cg = mysqli_query($s_conn, $cq) or die($s_conn->error . ' on line 21 of add-to-store-api.php');
  //echo 'Code: ' . $product_code;
  if(mysqli_num_rows($cg) > 0 && $product_code != undefined && $product_code != 'undefined' && $product_code != 'Does not apply'){
    $cr = mysqli_fetch_array($cg);
    //Adjust Inventory Level up by the quantity...
    if($_REQUEST['import_ebay_listing'] != ''){
      $x->message = 'Product already exists in database. Import to Store Ignored.';
      $x->product_id = $cr['product_id'];
      #Insert Import Record...
      $ebay_listing_id = $_REQUEST['import_ebay_listing'];
      $iirq = "UPDATE `ebay_imports` SET `date` = CURRENT_TIMESTAMP, `time` = CURRENT_TIMESTAMP, `status` = 'Imported', `product_id` = '" . $cr['product_id'] . "' WHERE `listing_id` = '" . $ebay_listing_id . "' AND `user_id` = '" . $_SESSION['user_id'] . "'";
      /*$iirq = "INSERT INTO `ebay_imports`
                (
                `date`,
                `listing_id`,
                `item_title`,
                `item_upc`,
                `product_id`,
                `user_id`,
                `user_name`,
                `inactive`
                )
                VALUES
                (
                CURRENT_TIMESTAMP,
                '" . $ebay_listing_id . "',
                '" . $product_title . "',
                '" . $product_code . "',
                '" . $product_id . "',
                '" . $_SESSION['user_id'] . "',
                '" . $_SESSION['user_name'] . "',
                'No'
                )";*/
        mysqli_query($conn, $iirq) or die($conn->error . ' on line 53 of add-to-store-api.php');
        $x->message .= ' - ebay_imports record inserted';
    }else{
      $iuq = "UPDATE `oc_product` SET `quantity` = `quantity` + " . intval($product_quantity) . " WHERE `upc` = '" . mysqli_real_escape_string($s_conn,$product_code) . "'";
      mysqli_query($s_conn, $iuq) or die($s_conn->error . ' on line 26 of add-to-store-api.php');
      $x->message = 'Product already exists in database. Inventory level adjusted';
      $x->product_id = $cr['product_id'];
    }
    
  }else{
    $x->message = 'Event Thread';
    
    //Get or add manufacturer ID...
    $mq = "SELECT * FROM `oc_manufacturer` WHERE `name` LIKE '%" . mysqli_real_escape_string($s_conn,$product_brand) . "%'";
    $mg = mysqli_query($s_conn, $mq) or die($s_conn->error . ' on line 35 of add-to-store-api.php');
    if(mysqli_num_rows($mg) > 0){
      $product_manufacturer_id = $mr['manufacturer_id'];
    }else{
      $miq = "INSERT INTO `oc_manufacturer` (`name`,`sort_order`) VALUES ('" . mysqli_real_escape_string($s_conn,$product_brand) . "','0')";
      mysqli_query($s_conn, $miq) or die($s_conn->error . ' on line 40 of add-to-store-api.php');
      $product_manufacturer_id = $s_conn->insert_id;
    }
    $x->message .= ' - manufacturer_id found';
    
    
    //Insert into the products table...
    $iq = "INSERT INTO `oc_product`
          (
          `model`,
          `upc`,
          `quantity`,
          `stock_status_id`,
          `image`,
          `manufacturer_id`,
          `shipping`,
          `price`,
          `tax_class_id`,
          `date_available`,
          `weight`,
          `weight_class_id`,
          `length`,
          `width`,
          `height`,
          `length_class_id`,
          `subtract`,
          `minimum`,
          `status`,
          `date_added`,
          `date_modified`
          )
          VALUES
          (
          '" . mysqli_real_escape_string($s_conn,$product_code) . "',
          '" . mysqli_real_escape_string($s_conn,$product_code) . "',
          '" . mysqli_real_escape_string($s_conn,$product_quantity) . "',
          '7',
          '" . mysqli_real_escape_string($s_conn,$product_image1) . "',
          '" . $product_manufacturer_id . "',
          '1',
          '" . mysqli_real_escape_string($s_conn,$website_product_price) . "',
          '9',
          CURRENT_DATE,
          '" . mysqli_real_escape_string($s_conn,$pkg_weight) . "',
          '5',
          '" . mysqli_real_escape_string($s_conn,$product_pkg_length) . "',
          '" . mysqli_real_escape_string($s_conn,$product_pkg_width) . "',
          '" . mysqli_real_escape_string($s_conn,$product_pkg_depth) . "',
          '3',
          '1',
          '1',
          '1',
          CURRENT_TIMESTAMP,
          CURRENT_TIMESTAMP
          )";
    $ig = mysqli_query($s_conn, $iq) or die('Insert oc_product error: ' . $s_conn->error . ' on line 95 of add-to-store-api.php');
    $new_product_id = $s_conn->insert_id;
    $x->product_id = $new_product_id;
    $x->message .= ' - oc_product inserted';
    
    //Insert Product Description Details...
    $diq = "INSERT INTO `oc_product_description` 
            (
            `product_id`,
            `language_id`,
            `name`,
            `description`,
            `tag`,
            `meta_title`,
            `meta_description`,
            `meta_keyword`
            )
            VALUES
            (
            '" . $new_product_id . "',
            '1',
            '" . mysqli_real_escape_string($s_conn,$website_product_title) . " - " . mysqli_real_escape_string($s_conn,$product_size) . "',
            '" . mysqli_real_escape_string($s_conn,htmlentities($website_product_description)) . "',
            '" . mysqli_real_escape_string($s_conn,$website_product_title) . " | 81 Outfitters',
            '" . mysqli_real_escape_string($s_conn,$website_product_title) . " | 81 Outfitters',
            '" . mysqli_real_escape_string($s_conn,$website_product_title) . " | 81 Outfitters',
            '" . mysqli_real_escape_string($s_conn,$website_product_title) . " | 81 Outfitters'
            )";
    mysqli_query($s_conn, $diq) or die('Insert oc_product_description error: ' . $s_conn->error . ' on line 123 of add-to-store-api.php');
    $x->message .= ' - oc_product_description inserted';
    
    //Insert Product Attributes...
    $is_array = explode(',',$_REQUEST['item_specifics_array']);
    array_push($is_array,'color','brand','Size','Style','Type');
    foreach($is_array as $is){
        if($_REQUEST['product_'.$is] != ''){
            
          //Check if Attribute Exists...
          //$aq = "SELECT * FROM `oc_attribute_description` WHERE `language_id` = '1' AND `name` LIKE '%" . mysqli_real_escape_string($s_conn,str_replace('_',' ',$is)) . "%'";
          $aq = "SELECT * FROM `oc_attribute_description` WHERE `language_id` = '1' AND `name` = '" . mysqli_real_escape_string($s_conn,str_replace('_',' ',$is)) . "'";
          $ag = mysqli_query($s_conn, $aq) or die('Select oc_attribute_description error ' . $s_conn->error . ' on line 133 of add-to-store-api.php');
          $attribute_exists = false;
          if(mysqli_num_rows($ag) <= 0){
            //Get new Attribute ID...
            $aiq = "INSERT INTO `oc_attribute` (`attribute_group_id`,`sort_order`) VALUES ('6','0')";
            $aig = mysqli_query($s_conn, $aiq) or die('Insert oc_attribute error ' . $s_conn->error . ' on line 137 of add-to-store-api.php');
            $new_attribute_id = $s_conn->insert_id;
            //Add Attribute Details...
            $adiq = "INSERT INTO `oc_attribute_description` (`attribute_id`,`language_id`,`name`) VALUES ('" . $new_attribute_id . "','1','" . mysqli_real_escape_string($s_conn,str_replace('_',' ',$is)) . "')";
            $adig = mysqli_query($s_conn, $adiq) or die('Insert oc_attribute_description error ' . $s_conn->error . ' on line 141 of add-to-store-api.php');
          }else{
            //Get Current Attribute ID...
            $ar = mysqli_fetch_array($ag);
            $new_attribute_id = $ar['attribute_id'];
            $attribute_exists = true;
          }
          
          //Check if attribute exists for product...
          $eaq = "SELECT * FROM `oc_product_attribute` WHERE `product_id` = '" . $new_product_id . "' AND `attribute_id` = '" . $new_attribute_id . "' AND `language_id` = '1'";
          $eag = mysqli_query($s_conn, $eaq) or die($s_conn->error . ' on line 159 of add-to-store-api.php');
          if(mysqli_num_rows($eag) > 0){
            $product_attribute_exists = true;
          }else{
            $product_attribute_exists = false;
          }
          //Insert Attribute Info for Product...
          $paiq = "INSERT INTO `oc_product_attribute`
                    (
                    `product_id`,
                    `attribute_id`,
                    `language_id`,
                    `text`
                    )
                    VALUES
                    (
                    '" . $new_product_id . "',
                    '" . $new_attribute_id . "',
                    '1',
                    '" . mysqli_real_escape_string($s_conn,$_REQUEST['product_'.$is]) . "'
                    )";
          if($product_attribute_exists == false){
            mysqli_query($s_conn, $paiq) or die('Insert oc_product_attribute error: ' . $s_conn->error . ' on line 163 of add-to-store-api.php ' . $new_attribute_id . ' -> ' . $_REQUEST['product_'.$is]);
            $x->message .= ' - item specific [' . str_replace('_',' ',$is) . '] inserted';
          }else{
            $x->message .= ' - item specific [' . str_replace('_',' ',$is) . '] ALREADY EXISTS!';
          }
          
        }
    }//End foreach loop on attributes...
    
    //Insert All additional images to the system...
    //$new_img_array = array_shift($img_array);
    $i = 0;
    foreach($img_array as $img){
      if($i != 0){
        $iiq = "INSERT INTO `oc_product_image` (`product_id`,`image`,`sort_order`) VALUES ('" . $new_product_id . "','" . $img . "','0')";
        mysqli_query($s_conn, $iiq) or die($s_conn->error . ' on line 175 of add-to-store-api.php');
        $x->message .= ' - image ' . $i . ' inserted';
      }
      $i++;
    }
    
    //Add Category to Product...
    //Cat1...
    $cuq = "INSERT INTO `oc_product_to_category` (`product_id`,`category_id`) VALUES ('" . $new_product_id . "','" . $prod_81_cat_1 . "')";
    mysqli_query($s_conn, $cuq) or die($s_conn->error . ' on line 206 of add-to-store-api.php');
    $x->message .= ' - Category1 Inserted [' . $prod_81_cat_1 . ']';
    //Cat2...
    $cuq = "INSERT INTO `oc_product_to_category` (`product_id`,`category_id`) VALUES ('" . $new_product_id . "','" . $prod_81_cat_2 . "')";
    mysqli_query($s_conn, $cuq) or die($s_conn->error . ' on line 210 of add-to-store-api.php');
    $x->message .= ' - Category2 Inserted [' . $prod_81_cat_2 . ']';
    //Cat3...
    if($prod_81_cat_3 != ''){
    $cuq = "INSERT INTO `oc_product_to_category` (`product_id`,`category_id`) VALUES ('" . $new_product_id . "','" . $prod_81_cat_3 . "')";
    mysqli_query($s_conn, $cuq) or die($s_conn->error . ' on line 214 of add-to-store-api.php');
    $x->message .= ' - Category3 Inserted [' . $prod_81_cat_3 . ']';
    }
    if($prod_81_cat_4 != ''){
    //Cat4...
    $cuq = "INSERT INTO `oc_product_to_category` (`product_id`,`category_id`) VALUES ('" . $new_product_id . "','" . $prod_81_cat_4 . "')";
    mysqli_query($s_conn, $cuq) or die($s_conn->error . ' on line 218 of add-to-store-api.php');
    $x->message .= ' - Category4 Inserted [' . $prod_81_cat_4 . ']';
    }
    
    //Setup the Product Filters...
    //Size...
    if($product_size != ''){
      $groupID = 4;
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . $product_size . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 209 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 215 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . $product_size . "')";
        mysqli_query($s_conn, $ifdq) or die($s_conn->error . ' on line 218 of add-to-store-api.php');
      }
      $ipfq = "INSERT INTO `oc_product_filter` (`product_id`,`filter_id`) VALUES ('" . $new_product_id . "','" . $filter_id . "')";
      mysqli_query($s_conn, $ipfq) or die($s_conn->error . ' on line 221 of add-to-store-api.php');
      $x->message .= ' - Size product filter inserted';
      
      //Insert Filter to Category...
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_1 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_1 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_2 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_2 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_3 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_3 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_4 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_4 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
    }
    
    //Size Type...
    if($product_size_type != ''){
      $groupID = 5;
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . $product_size_type . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 237 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 243 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . $product_size_type . "')";
        mysqli_query($s_conn, $ifdq) or die($s_conn->error . ' on line 246 of add-to-store-api.php');
      }
      $ipfq = "INSERT INTO `oc_product_filter` (`product_id`,`filter_id`) VALUES ('" . $new_product_id . "','" . $filter_id . "')";
      mysqli_query($s_conn, $ipfq) or die($s_conn->error . ' on line 249 of add-to-store-api.php');
      $x->message .= ' - Size Type product filter inserted';
      
      //Insert Filter to Category...
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_1 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_1 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_2 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_2 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_3 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_3 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_4 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_4 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
    }
    
    //Color...
    if($product_color != ''){
      $groupID = 6;
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . $product_color . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 265 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 271 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . $product_color . "')";
        mysqli_query($s_conn, $ifdq) or die($s_conn->error . ' on line 274 of add-to-store-api.php');
      }
      $ipfq = "INSERT INTO `oc_product_filter` (`product_id`,`filter_id`) VALUES ('" . $new_product_id . "','" . $filter_id . "')";
      mysqli_query($s_conn, $ipfq) or die($s_conn->error . ' on line 277 of add-to-store-api.php');
      $x->message .= ' - Color product filter inserted';
      
      //Insert Filter to Category...
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_1 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_1 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_2 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_2 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_3 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_3 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_4 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_4 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
    }
    
    //Brand...
    if($product_brand != ''){
      $groupID = 7;
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . mysqli_real_escape_string($s_conn, $product_brand) . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 395 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 299 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . mysqli_real_escape_string($s_conn, $product_brand) . "')";
        mysqli_query($s_conn, $ifdq) or die($s_conn->error . ' on line 302 of add-to-store-api.php');
      }
      $ipfq = "INSERT INTO `oc_product_filter` (`product_id`,`filter_id`) VALUES ('" . $new_product_id . "','" . $filter_id . "')";
      mysqli_query($s_conn, $ipfq) or die($s_conn->error . ' on line 305 of add-to-store-api.php');
      $x->message .= ' - Brand product filter inserted';
      
      //Insert Filter to Category...
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_1 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_1 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_2 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_2 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_3 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_3 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_4 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_4 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
    }
    
    //Type...
    if($product_Type != ''){
      $groupID = 11;
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . $product_Type . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 383 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 389 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . $product_Type . "')";
        mysqli_query($s_conn, $ifdq) or die($s_conn->error . ' on line 392 of add-to-store-api.php');
      }
      $ipfq = "INSERT INTO `oc_product_filter` (`product_id`,`filter_id`) VALUES ('" . $new_product_id . "','" . $filter_id . "')";
      mysqli_query($s_conn, $ipfq) or die($s_conn->error . ' on line 305 of add-to-store-api.php');
      $x->message .= ' - Type product filter inserted';
      
      //Insert Filter to Category...
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_1 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_1 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_2 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_2 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_3 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_3 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_4 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_4 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
    }
    
    //Product Category Filtering...
    if($prod_81_cat_1 != ''){//Item Gender...
      $groupID = 10;
      
      //Get Category...
      $gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_1 . "'";
      $gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
      $gcr = mysqli_fetch_array($gcg);
      $cat1 = $gcr['name'];
      $cat1 = str_replace('Womens ','',$cat1);
      $cat1 = str_replace('Mens ','',$cat1);
      $cat1 = str_replace('Boys ','',$cat1);
      $cat1 = str_replace('Girls ','',$cat1);
      $cat1 = str_replace('Infants/Toddlers ','',$cat1);
      
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . $cat1 . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 325 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 331 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . $cat1 . "')";
        mysqli_query($s_conn, $ifdq) or die($s_conn->error . ' on line 334 of add-to-store-api.php');
      }
      $ipfq = "INSERT INTO `oc_product_filter` (`product_id`,`filter_id`) VALUES ('" . $new_product_id . "','" . $filter_id . "')";
      mysqli_query($s_conn, $ipfq) or die($s_conn->error . ' on line 337 of add-to-store-api.php');
      $x->message .= ' - Item Gender filter inserted';
      
      //Insert Filter to Category...
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_1 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_1 . "','" . $filter_id . "')";
        //mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_2 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_2 . "','" . $filter_id . "')";
        //mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_3 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_3 . "','" . $filter_id . "')";
        //mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_4 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_4 . "','" . $filter_id . "')";
        //mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
    }
    
    
    //Product Category Filtering...
    if($prod_81_cat_2 != ''){//Item Type...
      $groupID = 9;
      
      //Get Category...
      $gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_2 . "'";
      $gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
      $gcr = mysqli_fetch_array($gcg);
      $cat2 = $gcr['name'];
      $cat1 = str_replace('Womens ','',$cat1);
      $cat1 = str_replace('Mens ','',$cat1);
      $cat1 = str_replace('Boys ','',$cat1);
      $cat1 = str_replace('Girls ','',$cat1);
      $cat1 = str_replace('Infants/Toddlers ','',$cat1);
      
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . $cat2 . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 355 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 361 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . $cat2 . "')";
        mysqli_query($s_conn, $ifdq) or die($s_conn->error . ' on line 364 of add-to-store-api.php');
      }
      $ipfq = "INSERT INTO `oc_product_filter` (`product_id`,`filter_id`) VALUES ('" . $new_product_id . "','" . $filter_id . "')";
      mysqli_query($s_conn, $ipfq) or die($s_conn->error . ' on line 367 of add-to-store-api.php');
      $x->message .= ' - Item Category filter inserted';
      
      //Insert Filter to Category...
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_1 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_1 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 458 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_2 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 462 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_2 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 464 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_3 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 467 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_3 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 470 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_4 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_4 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
    }
    
    //Product Category Filtering...
    if($prod_81_cat_3 != ''){//Item Category...
      $groupID = 8;
      
      //Get Category...
      $gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_3 . "'";
      $gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
      $gcr = mysqli_fetch_array($gcg);
      $raw_store_category_text = $gcr['name'];
      $cat3 = $gcr['name'];
      $cat1 = str_replace('Womens ','',$cat1);
      $cat1 = str_replace('Mens ','',$cat1);
      $cat1 = str_replace('Boys ','',$cat1);
      $cat1 = str_replace('Girls ','',$cat1);
      $cat1 = str_replace('Infants/Toddlers ','',$cat1);
      
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . $cat3 . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 488 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 494 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . $cat3 . "')";
        mysqli_query($s_conn, $ifdq) or die($s_conn->error . ' on line 497 of add-to-store-api.php');
      }
      $ipfq = "INSERT INTO `oc_product_filter` (`product_id`,`filter_id`) VALUES ('" . $new_product_id . "','" . $filter_id . "')";
      mysqli_query($s_conn, $ipfq) or die($s_conn->error . ' on line 500 of add-to-store-api.php');
      $x->message .= ' - Item Category filter inserted';
      
      //Insert Filter to Category...
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_1 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 505 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_1 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 508 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_2 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 511 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_2 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 514 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_3 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 517 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_3 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 520 of add-to-store-api.php');
      }
      $cfq = "SELECT * FROM `oc_category_filter` WHERE `category_id` = '" . $prod_81_cat_4 . "' AND `filter_id` = '" . $filter_id . "'";
      $cfg = mysqli_query($s_conn, $cfq) or die($s_conn->error . ' on line 226 of add-to-store-api.php');
      if(mysqli_num_rows($cfg) <= 0){
        $cfiq = "INSERT INTO `oc_category_filter` (`category_id`,`filter_id`) VALUES ('" . $prod_81_cat_4 . "','" . $filter_id . "')";
        mysqli_query($s_conn, $cfiq) or die($s_conn->error . ' on line 229 of add-to-store-api.php');
      }
    }
    
    //Add Product to the Store...
    $siq = "INSERT INTO `oc_product_to_store` (`product_id`,`store_id`) VALUES ('" . $new_product_id . "','0')";
    mysqli_query($s_conn, $siq) or die($s_conn->error . ' on line 526 of add-to-store-api.php');
    $x->message .= ' - oc_product_to_store inserted';
    
    
  //Setup Ebay Profile for Syncing...
  if(($_REQUEST['submit_to_ebay'] == 'on' && $_REQUEST['submit_to_store'] == 'on') || $_REQUEST['ebay_import'] == 'Yes'){
      
      if($_REQUEST['ebay_import'] == 'Yes'){
        $ebay_listing_id = $_REQUEST['import_ebay_listing'];
      }else{
        $ebay_listing_id = $ebay_item_id;
      }
      
    #Check if profile exists for category pair...
    $pcq = "SELECT * FROM `oc_kb_ebay_profiles` WHERE `ebay_category_id` = '" . $product_category . "' AND `store_category_id` = '" . $product_81_store_category . "'";
    $pcg = mysqli_query($s_conn, $pcq) or die($s_conn->error . ' on line 532 of add-to-store-api.php');
    if(mysqli_num_rows($pcg) > 0){
      #Profile found and ID retrieved...
      $pcr = mysqli_fetch_array($pcg);
      $profile_id = $pcr['id_ebay_profiles'];
      $x->message .= ' - oc_kb_ebay_profiles inserted';
    }else{
      #Get Ebay Category Text...
      $ectq = "SELECT * FROM `oc_kb_ebay_categories` WHERE `ebay_categories` = '" . $product_category . "'";
      $ectg = mysqli_query($s_conn, $ectq) or die($s_conn->error . ' on line 678 of add-to-store-api.php');
      $ectr = mysqli_fetch_array($ectg);
      $ebay_category_text = mysqli_real_escape_string($s_conn, $ectr['ebay_category_name']);
      
      #Profile not found, adding new profile...
      $npq = "INSERT INTO `oc_kb_ebay_profiles` 
              (
              `profile_name`,
              `ebay_site`,
              `ebay_category_id`,
              `ebay_catgeory_text`,
              `ebay_payment_method`,
              `ebay_currency`,
              `ebay_language`,
              `ebay_shipping_profile`,
              `store_category_id`,
              `store_category_text`,
              `duration`,
              `product_quantity`,
              `dispatch_days`,
              `price_management`,
              `increase_decrease`,
              `product_price`,
              `product_threshold_price`,
              `percentage_fixed`,
              `product_condition`,
              `status`,
              `return_enable`,
              `return_days`,
              `refund`,
              `return_description`,
              `return_shipping`,
              `active`,
              `site_id`,
              `date_added`,
              `date_modified`,
              `vat_percentage`,
              `html_template`,
              `store_category`
              )
              VALUES
              (
              'ebay " . mysqli_real_escape_string($s_conn, $ebay_category_text) . " > website " . mysqli_real_escape_string($s_conn, $raw_store_category_text) . "',
              '0',
              '" . $product_category . "',
              '" . mysqli_real_escape_string($s_conn, $ebay_category_text) . "',
              'PayPal',
              'USD',
              '1',
              '1',
              '" . $product_81_store_category . "',
              '" . mysqli_real_escape_string($s_conn, $raw_store_category_text) . "',
              'GTC',
              '0',
              '0',
              '0',
              '0',
              '0',
              '0',
              '0',
              '1000',
              'completed',
              'ReturnsAccepted',
              'Days_30',
              'MoneyBack',
              '',
              'Seller',
              '1',
              '0',
              CURRENT_TIMESTAMP,
              CURRENT_TIMESTAMP,
              '0',
              '" . mysqli_real_escape_string($s_conn,htmlentities($website_product_description)) . "',
              '" . $product_store_category . "'
              )";
        mysqli_query($s_conn, $npq) or die($s_conn->error . ' on line 753 of add-to-store-api.php');
        $x->message .= ' - oc_kb_ebay_profiles created';
        $profile_id = $s_conn->insert_id;
        
    }
    
    #Check for product in the profile...
    $icq = "SELECT * FROM `oc_kb_ebay_profile_products` WHERE `id_ebay_profiles` = '" . $profile_id . "' && `id_ebay_profiles` IS NOT NULL AND `id_product` = '" . $new_product_id . "' AND `id_product` IS NOT NULL";
    $icg = mysqli_query($s_conn, $icq) or die($s_conn->error);
    if(mysqli_num_rows($icg) > 0){
      $x->message .= ' - oc_kb_ebay_profile_products already exists...';
    }else{
      $ipq = "INSERT INTO `oc_kb_ebay_profile_products`
              (
              `id_ebay_profiles`,
              `id_product`,
              `id_product_attribute`,
              `product_reference`,
              `upc`,
              `ebay_listiing_id`,
              `status`,
              `local_sync_flag`,
              `relist`,
              `revise`,
              `end`,
              `date_added`,
              `item_url`,
              `is_disabled`
              )
              VALUES
              (
              '" . $profile_id . "',
              '" . $new_product_id . "',
              '0',
              '" . mysqli_real_escape_string($s_conn, $product_code) . "',
              '" . mysqli_real_escape_string($s_conn, $product_code) . "',
              '" . $ebay_listing_id . "',
              'Listed',
              '0',
              '0',
              '0',
              '0',
              CURRENT_TIMESTAMP,
              'https://www.ebay.com/itm/" . $ebay_listing_id . "',
              '0'
              )";
      mysqli_query($s_conn, $ipq) or die($s_conn->error . ' on line 799 of add-to-store-api.php');
      $x->message .= ' - oc_kb_ebay_profile_products inserted';
    }
      
    #Insert Import Record...
    $iirq = "UPDATE `ebay_imports` SET `date` = CURRENT_TIMESTAMP, `time` = CURRENT_TIMESTAMP, `status` = 'Imported', `product_id` = '" . $new_product_id . "' WHERE `listing_id` = '" . $ebay_listing_id . "' AND `user_id` = '" . $_SESSION['user_id'] . "'";
    /*$iirq = "INSERT INTO `ebay_imports`
              (
              `date`,
              `listing_id`,
              `item_title`,
              `item_upc`,
              `user_id`,
              `user_name`,
              `inactive`
              )
              VALUES
              (
              CURRENT_TIMESTAMP,
              '" . $ebay_listing_id . "',
              '" . $product_title . "',
              '" . $product_code . "',
              '" . $_SESSION['user_id'] . "',
              '" . $_SESSION['user_name'] . "',
              'No'
              )";*/
    //if($_REQUEST['ebay_import'] == 'Yes'){
      mysqli_query($conn, $iirq) or die($conn->error . ' on line 825 of add-to-store-api.php');
      $x->message .= ' - ebay_imports record inserted';
    //}
    
   }//End of Ebay_Sync Script...
    
  }//End If Item Exists Check...
  
}//End API Key Check...

//$store_response = json_encode($x, JSON_PRETTY_PRINT);
$store_response = $x;
//echo $store_response->message;
