<?php
session_start();
include '../../assets/php/connection.php';

echo '
<html>
<head>
<title>Item Cross-Check Report</title>
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
<h1 style="text-align:center;">Item Cross-Check Report</h1>
';

 echo '<table>
        <thead>
         <tr style="background:lightgray;">
         <th>#</td>
         <th>Item Name</th>
         <th>81O ItemID</th>
         <th>UPC</th>
         <th>81O Qty</th>
         <th>Ebay ItemID</th>
         <th>Ebay Status</th>
         <th>Ebay Profiles</th>
         <th>Imported</td>
         </tr>
         </thead>
         <tbody>';

//Get Item List from 81O Store Database...
$ilq = "SELECT * FROM `oc_product` AS `p` LEFT JOIN `oc_product_description` AS `pd` ON `p`.`product_id` = `pd`.`product_id`";
$ilg = mysqli_query($s_conn, $ilq) or die($s_conn->error);
$i = 1;
while($ilr = mysqli_fetch_array($ilg)){
  //Check for duplicate profile_products...
  $dppq = "SELECT *, COUNT(`id_product`) AS `profile_count`
            FROM `oc_kb_ebay_profile_products`
            WHERE `id_product` = '" . $ilr['product_id'] . "'
            GROUP BY `id_product`
            HAVING COUNT(`id_product`) >= 1";
  $dppg = mysqli_query($s_conn, $dppq) or die($s_conn->error);
  $dppr = mysqli_fetch_array($dppg);
  if($dppr['ebay_status'] == ''){
    $status = $dppr['status'];
  }else{
    $status = $dppr['ebay_status'];
  }
  
  //Check if imported through the Reseller App...
  $icq = "SELECT * FROM `ebay_imports` WHERE `listing_id` = '" . $dppr['ebay_listiing_id'] . "'";
  $icg = mysqli_query($conn, $icq) or die($conn->error);
  $import_count = mysqli_num_rows($icg);
  if($import_count <= 0){
    $import_count = '';
  }

  echo '<tr>
          <td>' . $i . '</td>
          <td>' . $ilr['name'] . '</td>
          <td>' . $ilr['product_id'] . '</td>
          <td>' . $dppr['upc'] . '</td>
          <td>' . $ilr['quantity'] . '</td>
          <td>' . $dppr['ebay_listiing_id'] . '</td>
          <td>' . $status . '</td>
          <td>' . $dppr['profile_count'] . '</td>
          <td>' . $import_count . '</td>
        </tr>';
  
  $i++;
}

echo '</tbody>
      </table>';

echo '</body>
</html>';

?>