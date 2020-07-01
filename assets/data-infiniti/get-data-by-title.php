<?php
header('Content-Type: application/json');
include '../php/connection.php';
error_reporting(0);

//Load Variables...
$pTitle = mysqli_real_escape_string($conn, $_REQUEST['pTitle']);
$upc = $_REQUEST['upc'];

//Set API EndPoint...
$url = 'https://api.datafiniti.co/v4/products/search';

// Set your API parameters here.
$APIToken = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIzZnJvZ2lxcWtsbG5qMzczdnozczdpdDNpazFldXdleSIsImlzcyI6ImRhdGFmaW5pdGkuY28ifQ.DcEoYGaA7sQYP8xbf2p3i0iUULTM5wM11evIZfjdI9fRaSAAj26DQIzDdfoDFDi1tNLOjq6_od6pXnq68MANtxCnXcSlvy7bbT6yfekVt7UAQAVbLKYzQuv3XZ1PheCeZha1VdLJArwtdx01rztv-BsWNXWeD5STOYUwuCq1E7dCMCLI7LzWIIFjahkXsXgd1bO2Gn0biOxsSGu1Z7bG7Ln_sdbziRztAtoGrBCA7Vuq-GTFDw-HGhtGC6D0lgbvXLbO_bNimY7gd2E8SJ1x2ViqfutNsbfPVsQkEBp2iZZrZGD3l1FEZ_GEDBu_tb97OaWoHh5-ErQlPd17SvGOuSiIdMNxzkyjgpSuTF44ln_isHPCUwop8h02FY3Lp52oEzpg8V3uMLAZ6ztArKwUqUVaGDaIcOVuRvTBGldMGBrLdQdODS2DyrjOvyHv9pTnxyLJiuGjUYIzL5lEw7O8c4t4GqdyH9QJ0VdOh59Hyd9jjw5r3diVgACz8qwwdATirgNZJaVzNsi1NjrYJEzKPfn_eaHw2jRIx5d_uZ_u7TGXO3Ku1o5k4mqUfKefV9ah4-azQpNdr4o0AZUJXpdSOEN58BAufRQT2cB3VJAEeQwC4TqOm53HxArrC5i7rMoIE7K8Tk6fFqP1Ihy_obXSTOkMKh_Tcx3crhIoq7tpjZ0';
$format = 'JSON';
if($upc != ''){
  $query = 'upc:("' . $upc . '")';
}else{
  $query = 'name:("' . $pTitle . '")';
}
$num_records = 1;
$download = false;

$request_body = array(
	'query' => $query,
	'format' => $format,
	'num_records' => $num_records,
	'download' => $download
);

$options = array(
	'http' => array (
		'header'  => "Authorization: Bearer " . $APIToken . "\r\n" . 
					 "Content-Type: application/json\r\n",
		'method'  => 'POST',
		'content' => json_encode($request_body)
	)
);

$context  = stream_context_create($options);
$r = file_get_contents($url, false, $context);
$rr = json_decode($r);
//$result = json_encode($rr, JSON_PRETTY_PRINT);
if ($result === FALSE) {
	$x->response = 'ERROR';
  $x->error_message = 'Error Processing Request...';
} else {
	$x->response = 'GOOD';
  $x->data = $rr;
}

//Response Data...
$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;
?>