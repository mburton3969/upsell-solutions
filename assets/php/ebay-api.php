<?php


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.ebay.com/buy/browse/v1/item_summary/search');


curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization:Bearer v^1.1#i^1#r^0#f^0#p^1#I^3#t^H4sIAAAAAAAAAOVYa2wUVRTu9rFYofgDRUJMWEYEtJnZOzudbWfobty+QgOlhS0IGKjzuLMdmZ0Z5t6hXY1aamzkTSAhMSaGEEOBEIwJfwghhkQMoIRGUBL4ISGImKj8wFAVA96ZPthWUpZSsIn7ZzL3nnvud77znblnL+gIFr/SNb+rtyQwIX93B+jIDwTYiaA4WFQ6uSB/elEeyDII7O6Y1VHYWXC9EklpwxaXQGRbJoKh9rRhItEfjFGuY4qWhHQkmlIaIhErYjLRsFCMMEC0HQtbimVQofqaGKVxarkqCxqvKJqmKRoZNQd8NlsxSuajvMaBcp6TokCSysk8Qi6sNxGWTByjIoAVaMDTHGhmoyLgRFZgOK5sJRVaBh2kWyYxYQAV9+GK/lonC+vIUCWEoIOJEypen6hLNibqa2oXNVeGs3zF+3lIYgm7aOhbtaXC0DLJcOHI2yDfWky6igIRosLxvh2GOhUTA2BGAd+nmlf5MkFho5qssAIrjAmTdZaTlvDIMLwRXaU131SEJtZx5kGEEjLkN6GC+98WERf1NSHvsdiVDF3ToROjaqsSKxJNTVS8QVdaJWhU0UttBA0jadHJquW0oMqaAACQaQmWsYCVlf6N+rz1szxsp2rLVHWPMxRaZOEqSFDDodzwIp/FDTFqNBudhIY9RNl2FQMcRohdeCCJLm41vbTCNCEi5L8+OAODqzF2dNnFcNDD8Amfohgl2bauUsMnfSn2q6cdxahWjG0xHG5ra2PaOMZyUuEIAGx4ecPCpNIK0xLl2Xq17tvrD15A634oCiQrkS7ijE2wtBOpEgBmiopzkYpItKKf96Gw4sNH/zWQFXN4aEGMWYFwkspXSBoQ5EhUANJYVEi8X6RhDweUpQydlpw1ENuGpEBaITpz09DRVZHjtQhXoUFajQoaXSZoGi3zapRmNQgBhLKsCBX/p0LJVepJxbJhk2XoSmZsBD9mYnfUJsnBmSo3Q96ThG7yyFX79w0VeaE+ziC9Wn/4QD0fiDiRbJ3xFM4oVjpsSeTT5g21+KhDuRiFZTfDpFyIMIGtktMl50U6kQhDCkXNfUlfGZIAcl9COhfVVfCoNvLrnSFM6qlWjB5qz/ZRkOJVN2NYKR1hXUGM7arWI0kvYdv16bSLJdmA9WN0svw3p8p9w9NJ2zWuYiI57UuurvY1TIyfYQatUxgHIst1SKvINHr9Q7O1Bprka4wdyzCgs4zNjQmv1kdI9jjL8UMeXKNTwRh2TeNI24qhEwm1jLfInkhGdQmPr6hZnhciXIQVhEeKq9rPaXMmx3agcP23TyzC+RbCUH0MPX546IVDPM//sZ2BY6AzcCQ/EADlgGZLwcvBgqWFBZMoRJoCBkmmKlvtjC5pDDl6TfJ/2oHMGpixJd3JDwb0i+eVP7KuOnavAtMGLzuKC9iJWTcf4IV7M0XsM8+XsALgOcBGAccKK8GL92YL2amFz+7YuT70w5mb702OXDh6Saxh5uzftQmUDBoFAkV5hZ2BvOdM6mp0zt6nPzvo9m5atXrC6q55N0r1bVUpY850uL1ixgcbT+fvqcXv7AhuOXHk6BcrnPjN7h2vlbcc/aWzeWfogLuvmP0mteHA+VfvbJkCZlX+nHr9kPz58ruT7xzv+u3vnu3JtecmJY+3vd+25LsrJyZtFb4M3u4+J75RfbJ4z5EpT82tOnbuk7qfzt46fblr8+ZI5dy5293SFrmhI/LSqd+v3T0b3XRo26dXU8lob6z40q9vX/t6w9pua92CK7s+Ork0/vEFdfGpYN33vVdn1h7Yu+/wvJ7Vm4IXu2+LtxaceHfm4cNv/XV9dvmlG39W6gfrjI1np11+6TqzrmfG1MRXZ/ZvrfuwcXbJhEjPj31p/AfKobxmhBIAAA=='
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