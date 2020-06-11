<?php  
// Assign image file to variable  
$image_name =  
'https://media.geeksforgeeks.org/wp-content/uploads/geeksforgeeks-15.png';  
     
// Load image file  
$image = imagecreatefrompng($image_name);   
  
// Use imagescale() function to scale the image 
$img = imagescale( $image, 1000.5, 276 ); 
  
// Output image in the browser  
header("Content-type: image/png");  
imagepng($img);  
  
?> 