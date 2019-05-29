<?php


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.ebay.com/buy/browse/v1/item_summary/search');


curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization:Bearer AgAAAA**AQAAAA**aAAAAA**cZDuXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4aiCZSApA2dj6x9nY+seQ**TAIFAA**AAMAAA**IZas2WPivlsNin9NfwSog+aXH2prpomRXTjv02XGpA0mHdYI1feeWFx2dhvPOT6S3RmWhR1hDtxaY5M9c8jI1qGQR4HEXTeWSiqg4tPoCddQJIpIriUw3HLRO6bnjlap/6ukjr+bdLT9VRY7kFbr7sUfYdF2/mU8/915kD0lT/zy+QUQOg6yqGo5yJBKoIEHhdLCQoSHJNzQLGRJN66ob5QPQVP9TGEgLsr8TfOU4RMRwkf/rtWPEWOCycTh+Xc39RrwxzCiFXjAyw7GA8NrgbgtMmRwN3y/u/XYv4wG71ANrlxgjET38w+xSiT8kUMtiH42pFzK2D2i0p4T4h4PGDHJxG+b7FtRzGWG5iuqeYvDtssDiAEFG3UtIoSsRlrbPSunv9KbfocHMbS8E1/qN8y/oVFEwbtlQ2Lov2WpILhOpfSev1I/a/+xJnrBWUKgn3Tl/9w3NKD+fz5SGBsQJ4d/KBL+5Z69E0zSIAM/G3b5Lq+MlDJ1+oJvFpYSozg/aCME0l3+Omqx49SijwOHm5i1pakTiNa3eJcwlDd8JjK1FtIiuvAIk32nuPVEt8acfNiep5XFD8hlRcIdyz++0OMZ7KGMSYOTM9gOX+/Zv1631XDdh/1/2FVw8e7Ea4I9Vev5F1pvQysojUID9W62sEPnkecDRuo+bmMoy/UlLntHaIhKrddJtsQXmfQ0TLTSAFjfjuQPr5Dm1hOOcxHr59sJ6j2bukr71PlK0xv0iSZxZxh5NxXvyUSjgG+ekR+f'
));

curl_setopt($ch, CURLOPT_POST, 1);

$post_data = array(
	'category' => '108765',
	'q' => 'Beatles',
	'filter' => 'price:[200..500]',
	'filter' => 'priceCurrency:USD',
	'limit' => '10'
);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

$output = curl_exec($ch);

if($output === FALSE){
	echo 'cURL Error: ' . curl_error($ch);
}


curl_close($ch);

print_r($output);


?>