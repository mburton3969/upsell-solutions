<?php
session_start();
include '../../assets/php/connection.php';

//Load Variables...
$sdate = date("Y-m-d", strtotime($_REQUEST['sdate']));
$edate = date("Y-m-d", strtotime($_REQUEST['edate']));
if($_REQUEST['submit_all']){
  $sub = '&submit_all=y';
}else{
  $sub = '&submit=y';
}
echo '
<html>
<head>
<title>User Productivity Report</title>
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

td:empty{
  background: red;
  color: white;
}

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
<h1 style="text-align:center;">User Productivity Report</h1>
';

if(!$_REQUEST['submit'] && !$_REQUEST['submit_all']){
  
  echo '<div style="margin:auto;text-align:center;">
          <h2><u>Select Date Range for Report</u></h2>
          <form action="user-productivity-report.php" method="post" />
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
          <a href="user-productivity-report.php" style="color:blue;">(Change Date Range)</a>
          <br><br>';

 echo '<table>
        <thead>
         <tr style="background:lightgray;">
         <th>User</td>
         <th>UPC Scans</th>
         <th>81O Listings</th>
         <th>Qty to 81O</th>
         <th>ebay Listings</th>
         <th>Qty to ebay</th>
         <th>ebay Imports</th>
         <th>SellBrite Listings</th>
         <th>QTY to SellBrite</th>
         <th>Quick Prints</th>
         <th>Total Actions</th>
         </tr>
        </thead>
        <tbody>';

//Get User List...
$ulq = "SELECT * FROM `users` WHERE `inactive` != 'Yes' AND `ID` != '1' ORDER BY `fname` ASC";
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
  $qp_count = 0;
  $sb_listings = 0;
  $sb_qty_listed = 0;
  
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
    if($lr['log_type'] == 'Listing_SellBrite' && $lr['listed'] == 'Yes'){
      $sb_listings++;
      $qty = json_decode($lr['request_data']);
      $sb_qty_listed = $sb_qty_listed + (int)$qty->product_quantity;
    }
    
  }
  
  //Check if imported through the Reseller App...
  if($_REQUEST['submit_all']){
    $icq = "SELECT * FROM `ebay_imports` WHERE `inactive` != 'Yes' AND `user_id` = '" . $ulr['ID'] . "' AND `status` = 'Imported'";
  }else{
    $icq = "SELECT * FROM `ebay_imports` WHERE `inactive` != 'Yes' AND `user_id` = '" . $ulr['ID'] . "' AND `status` = 'Imported' AND `date` >= '" . $sdate . "' AND `date` <= '" . $edate . "'";
  }
  $icg = mysqli_query($conn, $icq) or die($conn->error);
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
  $total_actions = $total_ebay_listings + $total_store_listings + $upc_scans + $ebay_imports + $sb_listings + $qp_count;
  
  //Get Quick Print Log info...
  if($_REQUEST['submit_all']){
    $qpq = "SELECT * FROM `qp_log` WHERE `inactive` != 'Yes' AND `user_id` = '" . $ulr['ID'] . "'";
  }else{
    $qpq = "SELECT * FROM `qp_log` WHERE `inactive` != 'Yes' AND `user_id` = '" . $ulr['ID'] . "' AND `date` >= '" . $sdate . "' AND `date` <= '" . $edate . "'";
  }
  
  $qpg = mysqli_query($conn, $qpq) or die($conn->error);
  $qp_count = mysqli_num_rows($qpg);
  
  echo '<tr>
          <td>
            <a href="user-activity-report.php?uid=' . $ulr['ID'] . '&sdate=' . $sdate . '&edate=' . $edate . $sub . '" target="_blank">
              ' . $ulr['fname'] . ' ' . $ulr['lname'] . '
            </a>
          </td>
          <td>' . $upc_scans . '</td>
          <td>' . $total_store_listings . '</td>
          <td>' . $store_qty_listed . '</td>
          <td>' . $total_ebay_listings . '</td>
          <td>' . $ebay_qty_listed . '</td>
          <td>' . $ebay_imports . '</td>
          <td>' . $sb_listings . '</td>
          <td>' . $sb_qty_listed . '</td>
          <td>' . $qp_count . '</td>
          <td>' . $total_actions . '</td>
        </tr>';
  
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
    "order": [
              [ 0, "asc" ]
             ]
  });
</script>
</html>';

?>