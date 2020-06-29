<?php
session_start();
include '../../assets/php/connection.php';

echo '
<html>
<head>
<title>Unused Size Report</title>
<style>
/* page */

html { font: 16px/1 "Open Sans", sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }

body { box-sizing: border-box; min-height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

th, td{
  border:1px solid black;
  padding:10px;
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
<h1 style="text-align:center;">Unused Size Report</h1>
';

 echo '<table>
        <thead>
         <tr style="background:lightgray;">
         <th>#</td>
         <th>Size Name</th>
         <th>Filter ID</th>
         <th>Filter Cat</th>
         <th>Actions</th>
         </tr>
         </thead>
         <tbody>';

//Get Item List from 81O Store Database...
$ilq = "SELECT * FROM `oc_filter_description` WHERE `filter_group_id` = '4'";
$ilg = mysqli_query($s_conn, $ilq) or die($s_conn->error);
$i = 1;
while($ilr = mysqli_fetch_array($ilg)){
  //Check for duplicate profile_products...
  $dppq = "SELECT * FROM `oc_product_filter` WHERE `filter_id` = '" . $ilr['filter_id'] . "'";
  $dppg = mysqli_query($s_conn, $dppq) or die($s_conn->error);
  //$dppr = mysqli_fetch_array($dppg);
  if(mysqli_num_rows($dppg) > 0){
    
  }else{
    if($ilr['filter_category'] == ''){
    echo '<tr id="row_' . $i . '">
          <td>' . $i . '</td>
          <td>' . $ilr['name'] . '</td>
          <td>' . $ilr['filter_id'] . '</td>
          <td>' . $ilr['filter_category'] . '</td>
          <td style="text-align:center;">
            <a href="javascript: remove_filter(' . $ilr['filter_id'] . ',' . $i . ');" style="text-decoration:none;color:black;">
              <span style="font-weight:bold;padding:5px;padding-right:10px;padding-left:10px;border-radius:50%;background:red;">X</span>
            </a>
          </td>
        </tr>';
  
    $i++;
    }
  }

  
}

echo '</tbody>
      </table>';

echo '</body>
<script>
function remove_filter(fid,row){
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      console.log(this.responseText);
      var r = JSON.parse(this.responseText);
      if(r.response === "GOOD"){
        document.getElementById("row_"+row).remove();
      }else{
        console.log("Error Removing Filter...");
      }
      
    }
  }
  xmlhttp.open(\'GET\', "http://beta.81outfitters.com/api/remove-filter.php?fid="+fid, true);
  xmlhttp.send();
}
</script>
</html>';

?>