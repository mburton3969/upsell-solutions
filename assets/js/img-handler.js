function add_item_img(){
  var iimg = document.getElementById('new_img_url');
  if(iimg.value === ''){
    alert('You must enter an image URL!');
    iimg.value = '';
    return;
  }
  
  var img = new Image();
    img.onload = function() {
      //alert(this.width + 'x' + this.height);
      //document.getElementById('img_size').innerHTML = this.width + 'x' + this.height;
      if(this.width < 500 && this.height < 500){
        iimg.value = '';
        alert('Your image ('+this.width+'x'+this.height+') is too small! Must be at least 500 Pixels in Height or Width.');
        
      }else{
        
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
      
      
     }
    img.src = iimg.value;
  
}

function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev,elem) {
  ev.dataTransfer.setData("ID", ev.target.id);
}

function drop(ev,elem) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("ID");
  var new_id = data.substr(data.length - 1);
  var new_src = document.getElementById('product_image'+new_id).src;
  var cur_src = elem.src;
  var cur_id = elem.id;
  cur_id = cur_id.substr(cur_id.length - 1);
  //Swap the images...
  document.getElementById('product_image'+new_id).src = cur_src;
  document.getElementById('img_url'+new_id).src = cur_src;
  document.getElementById('product_image'+cur_id).src = new_src;
  document.getElementById('img_url'+cur_id).src = new_src;
  console.log('Images Swapped!');
}


function remove_item_img(iid){
  var conf = confirm("Are you sure you want to remove this image?");
  if(conf === false){
    return;
  }
  var img = document.getElementById('product_image'+iid);
  var img_src = document.getElementById('img_url'+iid);
  
  img.src = 'https://via.placeholder.com/150';
  //img.removeAttribute('src');
  img_src.value = '';
  console.log('Image '+iid+' removed...');
}