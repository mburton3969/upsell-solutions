<?php
session_start();
include '../../assets/php/connection.php';

//Load Variables...
$uid = $_REQUEST['uid'];
$sdate = date("Y-m-d", strtotime($_REQUEST['sdate']));
$edate = date("Y-m-d", strtotime($_REQUEST['edate']));

echo '
<html>
<head>
<title>User Activity Report</title>
<link href="../../global/jquery/jquery-ui.css" rel="stylesheet" />
<style>
/* page */

html { font: 16px/1 "Open Sans", sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }

body { box-sizing: border-box; min-height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

th, td{
  border:1px solid black;
  padding:5px;
}

/*td:empty{
  background: red;
  color: white;
}*/

@media print {
	* { -webkit-print-color-adjust: exact; }
	html { background: none; padding: 0; }
	body { box-shadow: none; margin: 0; }
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page { margin: 0; }
</style>
</head>
<body>
<h1 style="text-align:center;">User Activity Report</h1>
';

if($uid == ''){
  
  echo '<div style="margin:auto;text-align:center;">
          <h2><u>Select Date Range for Report</u></h2>
          <form action="user-activity-report.php" method="post" />
            <select name="uid" required>
              <option value="">Select User</option>';
            $uq = "SELECT * FROM `users` WHERE `inactive` != 'Yes' ORDER BY `fname` ASC";
            $ug = mysqli_query($conn, $uq) or die($conn->error);
            while($ur = mysqli_fetch_array($ug)){
              echo '<option value="' . $ur['ID'] . '">' . $ur['fname'] . ' ' . $ur['lname'] . '</option>';
            }
      echo '</select>
            <input type="text" class="date" name="sdate" placeholder="Start Date" autocomplete="off" />
            <input type="text" class="date" name="edate" placeholder="End Date" autocomplete="off" />
            <input type="submit" name="submit" value="Submit" />
            <input type="submit" name="submit_all" value="View All Dates" />
          </form>
        </div>';
}else{
  echo '<b>Activity From:';
  if($_REQUEST['submit_all']){
    echo 'ALL ACTIVITY';
  }else{
    echo $_REQUEST['sdate'] . ' to ' . $_REQUEST['edate'];
  }
  echo '<b> 
          <a href="user-activity-report.php" style="color:blue;">(Change User or Date Range)</a>
          <br><br>';

 echo '<table id="report_table" style="font-size:13px;">
        <thead>
         <tr style="background:lightgray;">
         <th>Date</th>
         <th>Time</th>
         <th>Type</th>
         <th>Barcode</th>
         <th>Item</th>
         <th>Qty</th>
         <th>Data Found?</th>
         <th>Data Source</th>
         <th>Listed?</th>
         </tr>
        </thead>
        <tbody>';

//Get User List...
$ulq = "SELECT * FROM `users` WHERE `inactive` != 'Yes' AND `ID` != '1' AND `ID` = '" . $uid . "' ORDER BY `fname` ASC";
$ulg = mysqli_query($conn, $ulq) or die($conn->error);
while($ulr = mysqli_fetch_array($ulg)){
  //Counters...
  $upc_scans = 0;
  $ebay_listings = 0;
  $store_listings = 0;
  $ebay_imports = 0;
  $total_actions = 0;
  $ebay_qty_listed = 0;
  $store_qty_listed = 0;
  
  //Get UPC Log info...
  if($_REQUEST['submit_all']){
    $lq = "SELECT * FROM `upc_search_log` WHERE `user_id` = '" . $ulr['ID'] . "'";
  }else{
    $lq = "SELECT * FROM `upc_search_log` WHERE `user_id` = '" . $ulr['ID'] . "' AND `date` >= '" . $sdate . "' AND `date` <= '" . $edate . "'";
  }
  $lg = mysqli_query($conn, $lq) or die($conn->error);
  while($lr = mysqli_fetch_array($lg)){
    if($lr['log_type'] == 'UPC Scan'){
      $upc_scans++;
    }
    if($lr['log_type'] == 'Listing_Ebay' && $lr['listed'] == 'Yes'){
      $ebay_listings++;
      $qty = json_decode($lr['request_data']);
      $ebay_qty_listed = $ebay_qty_listed + (int)$qty->product_quantity;
    }
    if($lr['log_type'] == 'Listing_Store' && $lr['listed'] == 'Yes'){
      $store_listings++;
      $qty = json_decode($lr['request_data']);
      $store_qty_listed = $store_qty_listed + (int)$qty->product_quantity;
    }
    
    $x = json_decode($lr['request_data']);
    echo '<tr>
            <td>' . date("m/d/y",strtotime($lr['date'])) . '</td>
            <td>' . date("h:i A",strtotime($lr['time'])) . '</td>
            <td>' . $lr['log_type'] . '</td>
            <td>' . $lr['upc_code'] . '</td>
            <td>
              ' . $x->product_title;
            if($lr['log_type'] != 'UPC Scan'){
              echo '<br>
              <img src="' . $x->img_url1 . '" style="width:100%;" />';
            }
      echo '</td>
            <td>' . $x->product_quantity . '</td>
            <td>' . $lr['data_found'] . '</td>
            <td>' . $lr['data_source'] . '</td>
            <td>' . $lr['listed'] . '</td>
          </tr>';
    
  }
  
  //Check if imported through the Reseller App...
  if($_REQUEST['submit_all']){
    $icq = "SELECT * FROM `ebay_imports` WHERE `inactive` != 'Yes' AND `user_id` = '" . $uid . "' AND `status` = 'Imported'";
  }else{
    $icq = "SELECT * FROM `ebay_imports` WHERE `inactive` != 'Yes' AND `user_id` = '" . $uid . "' AND `status` = 'Imported' AND `date` >= '" . $sdate . "' AND `date` <= '" . $edate . "'";
  }
  $icg = mysqli_query($conn, $icq) or die($conn->error);
  while($icr = mysqli_fetch_array($icg)){
    echo '<tr>
          <td>' . date("m/d/y",strtotime($icr['date'])) . '</td>
          <td>' . date("h:i A",strtotime($icr['time'])) . '</td>
          <td>ebay Import</td>
          <td>' . $icr['item_upc'] . '</td>
          <td>
            ' . $icr['item_title'] . '
            <br>
            <img src="' . $icr['product_img'] . '" style="width:100%;" />  
          </td>
          <td>N/A</td>
          <td>N/A</td>
          <td>ebay.com</td>
          <td>' . $icr['listing_id'] . '</td>
        </tr>';
  }
  $import_count = mysqli_num_rows($icg);
  $ebay_imports = $import_count;
  
  //Setup Totals...
  $total_ebay_listings = $ebay_listings - $ebay_imports;
  if($total_ebay_listings < 0){
    $total_ebay_listings = 0;
  }
  $total_store_listings = $store_listings - $ebay_imports;
  if($total_store_listings < 0){
    $total_store_listings = 0;
  }
  $total_actions = $total_ebay_listings + $total_store_listings + $upc_scans + $ebay_imports;

  
  //Check if imported through the Reseller App...
  if($_REQUEST['submit_all']){
    $pq = "SELECT * FROM `qp_log` WHERE `inactive` != 'Yes' AND `user_id` = '" . $uid . "'";
  }else{
    $pq = "SELECT * FROM `qp_log` WHERE `inactive` != 'Yes' AND `user_id` = '" . $uid . "' AND `date` >= '" . $sdate . "' AND `date` <= '" . $edate . "'";
  }
  $pg = mysqli_query($conn, $pq) or die($conn->error);
  while($pr = mysqli_fetch_array($pg)){
    echo '<tr>
          <td>' . date("m/d/y",strtotime($pr['date'])) . '</td>
          <td>' . date("h:i A",strtotime($pr['time'])) . '</td>
          <td>Quick Print</td>
          <td>N/A</td>
          <td>
            Size: ' . $pr['size'] . '<br>
            Originally: $' . $pr['original'] . '<br>
            Now: $' . $pr['now'] . '
          </td>
          <td>N/A</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>N/A</td>
        </tr>';
  }
  
}


echo '</tbody>
      </table>';
  
}//End Main IF Statement...

echo '</body>
<!--JQuery Files-->
<script src="../../global/jquery/jquery.js"></script>
<script src="../../global/jquery/jquery-ui.js"></script>
<script>
  $(document).ready(function(){
    $( ".date" ).datepicker();
  });
</script>
<!-- Data Tables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.21/sorting/time.js"></script>
<script>
  $("#report_table").dataTable({
    "paging": false,
    "columnDefs": [
                    { type: "time-uni", targets: 1 }
                  ],
    "order": [
              [ 0, "asc" ],
              [ 1, "asc" ]
             ]
  });
</script>
</html>';

?>