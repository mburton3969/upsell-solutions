<?php
//header('Content-Type: application/json');
error_reporting(0);
include '../php/connection.php';

//Load Variables...
$batch_code = $_REQUEST['batch_code'];
if($batch_code == ''){
  echo '<h1>No Batch Code Provided...</h1>';
  die();
}

//Loop Through UPC Codes in Database...
$q = "SELECT * FROM `upc_codes` WHERE `inactive` != 'Yes' AND `data_source` = '' AND `item_source` != '' AND `batch_code` = '" . $batch_code . "' LIMIT 1";
$g = mysqli_query($conn, $q) or die($conn->error);
$rnums = mysqli_num_rows($g);
if($rnums <= 0){
  $rq = "SELECT * FROM `upc_codes` WHERE `inactive` != 'Yes' AND `item_source` != '' AND `batch_code` = '" . $batch_code . "'";
  $rg = mysqli_query($conn, $rq) or die($conn->error);
  $rcount = mysqli_num_rows($rg);
  $rrq = "SELECT * FROM `upc_codes` WHERE `inactive` != 'Yes' AND `data_source` != 'None' AND `data_source` != '' AND `item_source` != '' AND `batch_code` = '" . $batch_code . "'";
  $rrg = mysqli_query($conn, $rrq) or die($conn->error);
  $rrcount = mysqli_num_rows($rrg);
  $percent = number_format(($rrcount / $rcount) * 100,2);
  echo '<h1 style="color:green;">UPC Update Scan Completed...</h1>';
  echo '<h2>Rows Found: ' . $rrcount . ' Rows Total: ' . $rcount . ' Percent Complete: ' . $percent . '%</h2>';
}else{
  
  while($r = mysqli_fetch_array($g)){
    
    
      
      //Get Stats...
      $rq = "SELECT * FROM `upc_codes` WHERE `inactive` != 'Yes' AND `item_source` != '' AND `batch_code` = '" . $batch_code . "'";
      $rg = mysqli_query($conn, $rq) or die($conn->error);
      $rcount = mysqli_num_rows($rg);
      $rrq = "SELECT * FROM `upc_codes` WHERE `inactive` != 'Yes' AND `data_source` != 'None' AND `data_source` != '' AND `item_source` != '' AND `batch_code` = '" . $batch_code . "'";
      $rrg = mysqli_query($conn, $rrq) or die($conn->error);
      $rrcount = mysqli_num_rows($rrg);
      $percent = number_format(($rrcount / $rcount) * 100,2);

      //Get Number of Records...
      $nq = "SELECT * FROM `upc_codes` WHERE `inactive` != 'Yes' AND `data_source` = '' AND `item_source` != '' AND `batch_code` = '" . $batch_code . "'";
      $ng = mysqli_query($conn, $nq) or die($conn->error);
      $nrnums = mysqli_num_rows($ng);

      $upc = $r['upc_code'];
      $durl = 'http://' . $_SERVER['HTTP_HOST'] . '/assets/upc-data/scrape-additional-data.php?upc=' . $upc . '&src=' . $r['item_source'];
      //echo $durl;
      //break;
      $data = file_get_contents($durl);
      $d = json_decode($data);
      //var_dump($d);
      if($data != false && $d->response != 'ERROR'){

        //UPDATE UPC Data...
        $uq = "UPDATE `upc_codes` SET ";
        $uq .= "`date` = CURRENT_DATE,`time` = CURRENT_TIME,";
        if($r['brand'] == ''){
          $uq .= "`brand` = '" . mysqli_real_escape_string($conn,$d->brand) . "',";
        }
        if($r['item_title'] == ''){
          $uq .= "`item_title` = '" . mysqli_real_escape_string($conn,$d->title) . "',";
        }
        if($r['item_description'] == ''){
          $uq .= "`item_description` = '" . mysqli_real_escape_string($conn,$d->description) . "',";
        }
        if($r['long_description'] == ''){
          $uq .= "`long_description` = '" . mysqli_real_escape_string($conn,$d->description) . "',";
        }
        if($r['size'] == ''){
          $uq .= "`size` = '" . mysqli_real_escape_string($conn,$d->size) . "',";
        }
        if($r['color'] == ''){
          $uq .= "`color` = '" . mysqli_real_escape_string($conn,$d->color) . "',";
        }
        if($r['img1'] == ''){
          $uq .= "`img1` = '" . mysqli_real_escape_string($conn,$d->img1) . "',";
        }
        if($r['img2'] == ''){
          $uq .= "`img2` = '" . mysqli_real_escape_string($conn,$d->img2) . "',";
        }
        if($r['img3'] == ''){
          $uq .= "`img3` = '" . mysqli_real_escape_string($conn,$d->img3) . "',";
        }
        if($r['img4'] == ''){
          $uq .= "`img4` = '" . mysqli_real_escape_string($conn,$d->img4) . "',";
        }
        if($r['img5'] == ''){
          $uq .= "`img5` = '" . mysqli_real_escape_string($conn,$d->img5) . "',";
        }
        if($r['retail_price'] == ''){
          $uq .= "`retail_price` = '" . mysqli_real_escape_string($conn,$d->price) . "',";
        }
        if($r['item_weight'] == ''){
          $uq .= "`item_weight` = '" . mysqli_real_escape_string($conn,$d->weight) . "',";
        }
        if($r['data_source'] == ''){
          $uq .= "`data_source` = '" . mysqli_real_escape_string($conn,$d->data_source) . "',";
        }
        $uq .= "`inactive` = 'No'
              WHERE 
              `upc_code` = '" . $upc . "'";

        if(mysqli_query($conn, $uq)){
          //$x->response = 'GOOD';
          //$x->message = 'UPC ' . $upc . ' has been updated!';
          echo '<h1>UPC Code: ' . $upc . ' was updated successfully.<br>
                    Using ' . $d->data_source . '!<br>
                    UPC Codes To Be Scanned: ' . $nrnums . '</h1>';
          $cp = number_format(($rrcount / ($rcount - $nrnums) * 100),2);
          echo '<h2>Rows Found: ' . $rrcount . ' Rows Total: ' . $rcount . ' Current Percent Found: ' . $cp . '% Percent Complete: ' . $percent . '%</h2>';
          echo '<script>setTimeout(function(){window.location.reload();},500);</script>';
          //echo '<button type="button" onclick="window.location.reload();">Continue</button>';
        }else{
          //$x->response = 'ERROR';
          //$x->message = $conn-error;
          var_dump($data);
          echo '<h1 style="color:red;">Error: ' . $conn->error . '</h1>';
        }

      }else{
        //echo 'ERROR->';
        echo '<h1 style="color:red;">Error!<br><br>
              UPC Codes To Be Scanned: ' . $nrnums . '</h1>
              </h1>';
        $cp = number_format(($rrcount / ($rcount - $nrnums) * 100),2);
        echo '<h2>Rows Found: ' . $rrcount . ' Rows Total: ' . $rcount . ' Current Percent Found: ' . $cp . '% Percent Complete: ' . $percent . '%</h2>';
        $rs = json_decode($data);
        echo json_encode($rs);
        $uq = "UPDATE `upc_codes` SET ";
        $uq .= "`data_source` = 'None',";
        $uq .= "`inactive` = 'No'
            WHERE 
            `upc_code` = '" . $upc . "'";
        mysqli_query($conn, $uq) or die($conn->error);
        echo '<script>setTimeout(function(){window.location.reload();},500);</script>';
        /*echo '<button type="button" onclick="window.location.reload();">Continue</button>';
        echo '<script>
                alert("An Error Occurred!");
              </script>';*/
      }
      

  }//End while loop...
  
}//End if num rows more than zero...