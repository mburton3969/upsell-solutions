<?php
session_start();
include '../../assets/php/connection.php';

$user_token = $_REQUEST['user_token'];

echo '
<html>
<head>
<title>Invalid Size Report</title>
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
<h1 style="text-align:center;">Invalid Size Report</h1>
';

if($user_token == ''){
  
  echo '<div style="margin:auto;text-align:center;">
          <h2><u>You Must Enter a User Token for this Report:</u></h2>
          <form action="invalid-size-report.php" method="post" />
            <input type="text" class="form-control" name="user_token" id="user_token" placeholder="User Token" autocomplete="off" />
            <input type="submit" name="submit" value="Submit" />
          </form>
          <br><br>
          <img src="imgs/token-how-to.png" style="margin:auto;width:100%;" />
        </div>';
  
}else{
  
 echo '<table>
        <thead>
         <tr style="background:lightgray;">
         <th>#</td>
         <th>Item Name</th>
         <th>UPC</th>
         <th>81O ItemID</th>
         <th>Filter ID</th>
         <th>Size Name</th>
         <th>Size Cat</th>
         </tr>
         </thead>
         <tbody>';

//Get Item List from 81O Store Database...
$ilq = "SELECT * FROM `oc_product` AS `p` 
        LEFT JOIN `oc_product_description` AS `pd` ON `p`.`product_id` = `pd`.`product_id`
        LEFT JOIN `oc_product_filter` AS `pf` ON `p`.`product_id` = `pf`.`product_id`";
$ilg = mysqli_query($s_conn, $ilq) or die($s_conn->error);
$i = 1;
while($ilr = mysqli_fetch_array($ilg)){
  //Check for duplicate profile_products...
  $dppq = "SELECT * FROM `oc_filter_description` WHERE `filter_id` = '" . $ilr['filter_id'] . "'";
  $dppg = mysqli_query($s_conn, $dppq) or die($s_conn->error);
  $dppr = mysqli_fetch_array($dppg);
  
  if($dppr['filter_group_id'] == '4' && $dppr['filter_category'] == ''){
  echo '<tr>
          <td>' . $i . '</td>
          <td>' . $ilr['name'] . '</td>
          <td>' . $ilr['upc'] . '</td>
          <td>
          <a href="http://beta.81outfitters.com/admin/index.php?route=catalog/product/edit&user_token=' . $user_token . '&product_id=' . $ilr['product_id'] . '" target="_blank" onclick="clear_row(this);">
            ' . $ilr['product_id'] . '
            </a>
          </td>
          <td>' . $dppr['filter_id'] . '</td>
          <td>' . $dppr['name'] . '</td>
          <td>' . $dppr['filter_category'] . '</td>
        </tr>';
  
  $i++;
  }
}

echo '</tbody>
      </table>';
}//End Main IF...

echo '</body>
<script>
function clear_row(link){
  link.parentElement.parentElement.remove();
}
</script>
</html>';

?>