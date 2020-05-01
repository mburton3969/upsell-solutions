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
  if(mysqli_num_rows($cg) > 0){
    $cr = mysqli_fetch_array($cg);
    //Adjust Inventory Level up by the quantity...
    $iuq = "UPDATE `oc_product` SET `quantity` = `quantity` + " . intval($product_quantity) . " WHERE `upc` = '" . mysqli_real_escape_string($s_conn,$product_code) . "'";
    mysqli_query($s_conn, $iuq) or die($s_conn->error . ' on line 26 of add-to-store-api.php');
    $x->message = 'Product already exists in database. Inventory level adjusted';
    $x->product_id = $cr['product_id'];
    
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
          'Classic',
          '" . mysqli_real_escape_string($s_conn,$product_code) . "',
          '" . mysqli_real_escape_string($s_conn,$product_quantity) . "',
          '7',
          '" . mysqli_real_escape_string($s_conn,$product_image1) . "',
          '" . $product_manufacturer_id . "',
          '1',
          '" . mysqli_real_escape_string($s_conn,$product_price) . "',
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
            '" . mysqli_real_escape_string($s_conn,$product_title) . " - " . mysqli_real_escape_string($s_conn,$product_size) . "',
            '" . mysqli_real_escape_string($s_conn,htmlentities($product_description)) . "',
            '" . mysqli_real_escape_string($s_conn,$product_title) . " | 81 Outfitters',
            '" . mysqli_real_escape_string($s_conn,$product_title) . " | 81 Outfitters',
            '" . mysqli_real_escape_string($s_conn,$product_title) . " | 81 Outfitters',
            '" . mysqli_real_escape_string($s_conn,$product_title) . " | 81 Outfitters'
            )";
    mysqli_query($s_conn, $diq) or die('Insert oc_product_description error: ' . $s_conn->error . ' on line 123 of add-to-store-api.php');
    $x->message .= ' - oc_product_description inserted';
    
    //Insert Product Attributes...
    $is_array = explode(',',$_REQUEST['item_specifics_array']);
    foreach($is_array as $is){
        if($_REQUEST['product_'.$is] != ''){
            
          //Check if Attribute Exists...
          $aq = "SELECT * FROM `oc_attribute_description` WHERE `language_id` = '1' AND `name` LIKE '%" . mysqli_real_escape_string($s_conn,str_replace('_',' ',$is)) . "%'";
          $ag = mysqli_query($s_conn, $aq) or die('Select oc_attribute_description error ' . $s_conn->error . ' on line 133 of add-to-store-api.php');
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
          mysqli_query($s_conn, $paiq) or die('Insert oc_product_attribute error: ' . $s_conn->error . ' on line 163 of add-to-store-api.php ' . $new_attribute_id . ' -> ' . $_REQUEST['product_'.$is]);
          $x->message .= ' - item specific [' . str_replace('_',' ',$is) . '] inserted';
          
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
    //Parent Category...
    /*$pcuq = "SELECT * FROM `oc_category` WHERE `category_id` = '" . $prod_81_cat_1 . "'";
    $pcug = mysqli_query($s_conn, $pcuq) or die($s_conn->error . ' on line 184 of add-to-store-api.php');
    $pcur = mysqli_fetch_array($pcug);
    $parent_category = $pcur['parent_id'];
    if($parent_category != '0'){
      $x->message .= ' - Parent Category ERROR';
    }else{
      //Parent Category Insert...
      $cuq = "INSERT INTO `oc_product_to_category` (`product_id`,`category_id`) VALUES ('" . $new_product_id . "','" . $parent_category . "')";
      mysqli_query($s_conn, $cuq) or die($s_conn->error . ' on line 192 of add-to-store-api.php');
      $x->message .= ' - Parent Category Inserted [' . $parent_category . ']';
    }*/
    //Cat1...
    $cuq = "INSERT INTO `oc_product_to_category` (`product_id`,`category_id`) VALUES ('" . $new_product_id . "','" . $prod_81_cat_1 . "')";
    mysqli_query($s_conn, $cuq) or die($s_conn->error . ' on line 197 of add-to-store-api.php');
    $x->message .= ' - Category1 Inserted [' . $prod_81_cat_1 . ']';
    //Cat2...
    $cuq = "INSERT INTO `oc_product_to_category` (`product_id`,`category_id`) VALUES ('" . $new_product_id . "','" . $prod_81_cat_2 . "')";
    mysqli_query($s_conn, $cuq) or die($s_conn->error . ' on line 201 of add-to-store-api.php');
    $x->message .= ' - Category2 Inserted [' . $prod_81_cat_2 . ']';
    //Cat3...
    $cuq = "INSERT INTO `oc_product_to_category` (`product_id`,`category_id`) VALUES ('" . $new_product_id . "','" . $prod_81_cat_3 . "')";
    mysqli_query($s_conn, $cuq) or die($s_conn->error . ' on line 201 of add-to-store-api.php');
    $x->message .= ' - Category3 Inserted [' . $prod_81_cat_3 . ']';
    
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
    }
    
    //Brand...
    if($product_brand != ''){
      $groupID = 7;
      $fq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '" . $groupID . "' AND `language_id` = '1' AND `name` = '" . $product_brand . "'";
      $fg = mysqli_query($s_conn, $fq) or die($s_conn->error . ' on line 293 of add-to-store-api.php');
      if(mysqli_num_rows($fg) > 0){
        $fr = mysqli_fetch_array($fg);
        $filter_id = $fr['filter_id'];
      }else{
        $ifq = "INSERT INTO `oc_filter` (`filter_group_id`,`sort_order`) VALUES ('" . $groupID . "','0')";
        mysqli_query($s_conn, $ifq) or die($s_conn->error . ' on line 299 of add-to-store-api.php');
        $filter_id = $s_conn->insert_id;
        $ifdq = "INSERT INTO `oc_filter_description` (`filter_id`,`language_id`,`filter_group_id`,`name`) VALUES ('" . $filter_id . "','1','" . $groupID . "','" . $product_brand . "')";
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
    }
    
    //Product Category Filtering...
    if($prod_81_cat_1 != ''){//Item Type...
      $groupID = 8;
      //$prod_81_cat_1 = str_replace('Womens ','',$prod_81_cat_1);
      //$prod_81_cat_1 = str_replace('Mens ','',$prod_81_cat_1);
      //$prod_81_cat_1 = str_replace('Kids ','',$prod_81_cat_1);
      
      //Get Category...
      $gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_1 . "'";
      $gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
      $gcr = mysqli_fetch_array($gcg);
      $cat1 = $gcr['name'];
      $cat1 = str_replace('Womens ','',$cat1);
      $cat1 = str_replace('Mens ','',$cat1);
      $cat1 = str_replace('Kids ','',$cat1);
      
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
      $x->message .= ' - Item Type filter inserted';
      
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
    }
    
    
    //Product Category Filtering...
    if($prod_81_cat_2 != ''){//Item Category...
      $groupID = 9;
      
      //Get Category...
      $gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_2 . "'";
      $gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
      $gcr = mysqli_fetch_array($gcg);
      $cat2 = $gcr['name'];
      $cat2 = str_replace('Womens ','',$cat2);
      $cat2 = str_replace('Mens ','',$cat2);
      $cat2 = str_replace('Kids ','',$cat2);
      
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
    }
    
    //Add Product to the Store...
    $siq = "INSERT INTO `oc_product_to_store` (`product_id`,`store_id`) VALUES ('" . $new_product_id . "','0')";
    mysqli_query($s_conn, $siq) or die($s_conn->error . ' on line 381 of add-to-store-api.php');
    $x->message .= ' - oc_product_to_store inserted';
    
  }//End If Item Exists Check...
  
}//End API Key Check...

//$store_response = json_encode($x, JSON_PRETTY_PRINT);
$store_response = $x;
//echo $store_response->message;
