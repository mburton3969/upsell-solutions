<?php
//error_reporting(E_ALL);
/*
* Script to save the UPC Data on submit...
*/

//Check if UPC Code Exists...
$eq = "SELECT * FROM `upc_codes` WHERE `upc_code` = '" . $product_code . "'";
$eg = mysqli_query($conn, $eq) or die($conn->error);
if(mysqli_num_rows($eg) > 0){
  $er = mysqli_fetch_array($eg);
  
  //Update the UPC Data in the Database...
  $idq = "UPDATE `upc_codes` SET 
          `modified_date` = CURRENT_TIMESTAMP,
          `modified_source` = 'Reseller App Submit'";
  
  
  //Product Brand Update...
  if($er['brand'] == '' || ($er['brand'] != $product_brand && $product_brand != '')){
    $idq .= ",`brand` = '" . mysqli_real_escape_string($conn, $product_brand) . "'";
  }
  
  //Product Title Update...
  if($er['item_title'] == '' || ($er['item_title'] != $product_title && $product_title != '')){
    $idq .= ",`item_title` = '" . $product_title . "'";
  }
  
  //Product Description Update...
  if($er['item_description'] == '' || ($er['item_description'] != mysqli_real_escape_string($conn, $pd) && $pd != '')){
    $idq .= ",`item_description` = '" . mysqli_real_escape_string($conn, $pd) . "'";
  }
  if($er['long_description'] == '' || ($er['long_description'] != mysqli_real_escape_string($conn,$pd_extra) && $pd_extra != '')){
    $idq .= ",`long_description` = '" . mysqli_real_escape_string($conn, $pd_extra) . "'";
  }
  
  //Product Size Update...
  if($er['size'] == '' || ($er['size'] != $product_size && $product_size != '')){
    $idq .= ",`size` = '" . mysqli_real_escape_string($conn, $product_size) . "'";
  }
  
  //Product Color Update...
  if($er['color'] == '' || ($er['color'] != $product_color && $product_color != '')){
    $idq .= ",`color` = '" . mysql_real_escape_string($conn, $product_color) . "'";
  }
  
  //Product Image 1 Update...
  if($er['img1'] == '' || ($er['img1'] != $product_image1 && $product_image1 != '')){
    $idq .= ",`img1` = '" . mysqli_real_escape_string($conn, $product_image1) . "'";
  }
  
  //Product Image 2 Update...
  if($er['img2'] == '' || ($er['img2'] != $product_image2 && $product_image2 != '')){
    $idq .= ",`img2` = '" . mysqli_real_escape_string($conn, $product_image2) . "'";
  }
  
  //Product Image 3 Update...
  if($er['img3'] == '' || ($er['img3'] != $product_image3 && $product_image3 != '')){
    $idq .= ",`img3` = '" . mysqli_real_escape_string($conn, $product_image3) . "'";
  }
  
  //Product Image 4 Update...
  if($er['img4'] == '' || ($er['img4'] != $product_image4 && $product_image4 != '')){
    $idq .= ",`img4` = '" . mysqli_real_escape_string($conn, $product_image4) . "'";
  }
  
  //Product Image 5 Update...
  if($er['img5'] == '' || ($er['img5'] != $product_image5 && $product_image5 != '')){
    $idq .= ",`img5` = '" . mysqli_real_escape_string($conn, $product_image5) . "'";
  }
  
  //Product Price Update...
  if($er['retail_price'] == '' || ($er['retail_price'] != $product_price && $product_price != '')){
    $idq .= ",`retail_price` = '" . mysqli_real_escape_string($conn, $product_price) . "'";
  }
  
  //Product Weight Update...
  if($er['item_weight'] == '' || ($er['item_weight'] != $pkg_weight && $pkg_weight != '')){
    $idq .= ",`item_weight` = '" . mysqli_real_escape_string($conn, $pkg_weight) . "'";
  }
  
  $idq .= " WHERE
          `upc_code` = '" . $product_code . "'";
  
  if(mysqli_query($conn, $idq)){
    echo '<script>
            var success = document.getElementById("success");
            var h4 = document.createElement("h4");
            h4.innerHTML = "UPC Data Updated Successfully!";
            success.appendChild(h4);
          </script>';
  }else{
    echo '<script>
            var errors = document.getElementById("errors");
            var h4 = document.createElement("h4");
            h4.innerHTML = "Error Updating UPC Data: ' . $conn->error . ' on line 83 of /assets/store/save-upc-submit.php";
            errors.appendChild(h4);
          </script>';
  }
  //mysqli_query($conn, $idq) or die($conn->error);
  
  
  
}else{
  //INSERT Data Record into the Database...
  $idq = "INSERT INTO `upc_codes` 
        (
        `date`,
        `time`,
        `upc_code`,
        `brand`,
        `item_title`,
        `item_description`,
        `long_description`,
        `size`,
        `color`,
        `img1`,
        `img2`,
        `img3`,
        `img4`,
        `img5`,
        `retail_price`,
        `item_weight`,
        `data_source`,
        `inactive`
        )
        VALUES
        (
        CURRENT_DATE,
        CURRENT_TIME,
        '" . mysqli_real_escape_string($conn, $product_code) . "',
        '" . mysqli_real_escape_string($conn, $product_brand) . "',
        '" . mysqli_real_escape_string($conn, $product_title) . "',
        '" . mysqli_real_escape_string($conn, $pd) . "',
        '" . mysqli_real_escape_string($conn, $pd_extra) . "',
        '" . mysqli_real_escape_string($conn, $product_size) . "',
        '" . mysqli_real_escape_string($conn, $product_color) . "',
        '" . mysqli_real_escape_string($conn, $product_image1) . "',
        '" . mysqli_real_escape_string($conn, $product_image2) . "',
        '" . mysqli_real_escape_string($conn, $product_image3) . "',
        '" . mysqli_real_escape_string($conn, $product_image4) . "',
        '" . mysqli_real_escape_string($conn, $product_image5) . "',
        '" . mysqli_real_escape_string($conn, $product_price) . "',
        '" . mysqli_real_escape_string($conn, $pkg_weight) . "',
        'Reseller App',
        'No'
        )";
  
  if(mysqli_query($conn, $idq)){
    echo '<script>
            var success = document.getElementById("success");
            var h4 = document.createElement("h4");
            h4.innerHTML = "UPC Data Inserted Successfully!";
            success.appendChild(h4);
          </script>';
  }else{
    echo '<script>
            var errors = document.getElementById("errors");
            var h4 = document.createElement("h4");
            h4.innerHTML = "Error Inserting UPC Data: ' . $conn->error . ' on line 148 of /assets/store/save-upc-submit.php";
            errors.appendChild(h4);
          </script>';
  }
  //mysqli_query($conn, $idq) or die($conn->error);
  
}
//error_reporting(0);