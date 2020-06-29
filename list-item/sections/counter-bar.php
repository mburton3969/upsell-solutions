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