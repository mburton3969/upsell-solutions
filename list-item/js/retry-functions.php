<?php
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
    echo '},' . ($timer + 6000) . ');';
    
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
    //81 Store Cat 3...
    if(isset($_SESSION['form_data']['product_81_store_category_3']) && $_SESSION['form_data']['product_81_store_category_3'] != ''){
      echo 'console.warn("81 Store Category 3: ' . $_SESSION['form_data']['product_81_store_category_3'] . '");';
      echo 'setTimeout(function(){get_81_store_cats(3,"' . $_SESSION['form_data']['product_81_store_category_2'] . '","' . $_SESSION['form_data']['product_81_store_category_3'] . '");
      document.getElementById("cur_81_cat").value = "' . $_SESSION['form_data']['product_81_store_category_3'] . '";
      document.getElementById("loader").style.display = "none";},' . $timer . ');
      console.log("81StoreCat3");';
      $timer = $timer + 500;
    }
    
    echo 'setTimeout(function(){
            document.getElementById("loader").style.display = "none";
          },' . $timer . ');';
    
    echo '})();';
    echo '</script>';
  }//End of Retry mode...
  
  if($_REQUEST['upc_code'] != ''){
    echo '<script>
            (function(){
              lookup_upc(\'BYPASS\',\'' . $_REQUEST['upc_code'] . '\');
            })();
          </script>';
  }