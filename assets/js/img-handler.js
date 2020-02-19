function add_item_img(){
  var iimg = document.getElementById('new_img_url');
  if(iimg.value === ''){
    alert('You must enter an image URL!');
    return;
  }
  
  var img1 = document.getElementById('product_image1');
  var img1_src = document.getElementById('img_url1');
  var img2 = document.getElementById('product_image2');
  var img2_src = document.getElementById('img_url2');
  var img3 = document.getElementById('product_image3');
  var img3_src = document.getElementById('img_url3');
  var img4 = document.getElementById('product_image4');
  var img4_src = document.getElementById('img_url4');
  var img5 = document.getElementById('product_image5');
  var img5_src = document.getElementById('img_url5');
  
  if(img1_src.value === ''){
    img1.src = iimg.value;
    img1_src.value = iimg.value;
  }else if(img2_src.value === ''){
    img2.src = iimg.value;
    img2_src.value = iimg.value;
  }else if(img3_src.value === ''){
    img3.src = iimg.value;
    img3_src.value = iimg.value;
  }else if(img4_src.value === ''){
    img4.src = iimg.value;
    img4_src.value = iimg.value;
  }else if(img5_src.value === ''){
    img5.src = iimg.value;
    img5_src.value = iimg.value;
  }else{
    alert('5 Images have already been added. You may only have 5 images per item!');
    return;
  }
  iimg.value = '';
}


function remove_item_img(iid){
  var img = document.getElementById('product_image'+iid);
  var img_src = document.getElementById('img_url'+iid);
  
  img.src = '';
  img_src.value = '';
  console.log('Image '+iid+' removed...');
}