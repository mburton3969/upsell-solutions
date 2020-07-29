function de_parse(r,surl){
	document.getElementById('product_description_extra').value = r.description;
	document.getElementById('product_label').value = '';
	document.getElementById('brand_label').value = r.brand;
	document.getElementById('product_brand').value = r.brand;
	document.getElementById('product_code').value = r.upc_code;
	document.getElementById('product_image1').src = r.image;
  document.getElementById('img1_link').href = r.image;
	document.getElementById('img_url1').value = r.image;
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
  var nTitle = r.description.substring(0,80);
  nTitle =  nTitle.replace(r.brand,'');
	document.getElementById('product_title').value = nTitle;
	document.getElementById('response_message').innerHTML = '*Info Found via Digit-Eyes.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  get_ebay_item_prices(r.upc_code);
  format_ebay();
}


function bl_parse(res,surl){
	var r = res.products[0];
	console.log(r);
	document.getElementById('product_title').value = r.product_name.substring(0,80);
	document.getElementById('product_label').value = r.label;
	document.getElementById('product_description_extra').value = r.description;
	document.getElementById('product_code').value = r.barcode_number;
  for(var i = 0; i < 5; i++){
    if(r.images[i]){
      document.getElementById('product_image'+(i+1)+'').src = r.images[i];
      document.getElementById('img'+(i+1)+'_link').href = r.images[i];
      document.getElementById('img_url'+(i+1)+'').value = r.images[i];
    }
  }
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
  document.getElementById('product_color').value = r.color;
  document.getElementById('product_Size').value = r.size;
  if(r.brand !== ''){
	  document.getElementById('brand_label').value = r.brand;
    document.getElementById('product_brand').value = r.brand;
  }else{
	  document.getElementById('brand_label').value = r.manufacturer;
    document.getElementById('product_brand').value = r.manufacturer;
  }
	document.getElementById('response_message').innerHTML = '*Info Found via Barcodelookup.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  if(r.stores[0]){
    add_suggested_price(r.stores[0].store_price,r.stores[0].store_name);
    add_suggested_price('Google');
  }else{
    get_ebay_item_prices(r.barcode_number);
  }
  format_ebay();
}


function upc_parse(res,surl){
	var r = res.items[0];
	console.log(r);
	document.getElementById('product_title').value = r.title.substring(0,80);
	document.getElementById('product_label').value = '';
	document.getElementById('product_description_extra').value = r.description;
	document.getElementById('product_code').value = r.upc;
	document.getElementById('brand_label').value = r.brand;
	document.getElementById('product_brand').value = r.brand;
	document.getElementById('product_image1').src = r.images[0];
  document.getElementById('img1_link').href = r.images[0];
	document.getElementById('img_url1').value = r.images[0];
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('product_Size').value = r.size;
	document.getElementById('product_color').value = r.color;
  document.getElementById('product_msrp').value = r.highest_recorded_price.toFixed(2);
	document.getElementById('response_message').innerHTML = '*Info Found via upcitemdb.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  if(r.lowest_recorded_price !== '' || r.highest_recorded_price !== ''){
    add_suggested_price(r.lowest_recorded_price,'Unknown');
    add_suggested_price(r.highest_recorded_price,'Unknown');
    add_suggested_price('Google');
  }else{
    get_ebay_item_prices(r.upc);
  }
  format_ebay();
}


function wm_parse(res,surl){
	var r = res.items[0];
	console.log(r);
	var nTitle = r.name.substring(0,80);
  nTitle =  nTitle.replace(r.brandName,'');
	document.getElementById('product_title').value = nTitle;
	document.getElementById('product_label').value = '';
	document.getElementById('product_code').value = r.upc;
	document.getElementById('product_description_extra').value = r.shortDescription;
  for(var i = 0; i < 5; i++){
    if(r.imageEntities[i]){
      document.getElementById('product_image'+(i+1)+'').src = r.imageEntities[i].largeImage;
      document.getElementById('img'+(i+1)+'_link').href = r.imageEntities[i].largeImage;
      document.getElementById('img_url'+(i+1)+'').value = r.imageEntities[i].largeImage;
    }
  }
	document.getElementById('product_price').value = '';
  document.getElementById('product_color').value = r.color;
	document.getElementById('product_quantity').value = '';
	document.getElementById('brand_label').value = r.brandName;
	document.getElementById('product_brand').value = r.brandName;
	document.getElementById('product_Size').value = r.size;
  document.getElementById('product_msrp').value = r.msrp.toFixed(2);
	document.getElementById('response_message').innerHTML = '*Info Found via walmart.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  get_ebay_item_prices(r.upc);
  format_ebay();
}


function bs_parse(res,surl){
	var r = res;
	console.log(r);
	var nTitle = r.title.substring(0,80);
  //nTitle =  nTitle.replace(r.brandName,'');
	document.getElementById('product_title').value = nTitle;
	document.getElementById('product_code').value = r.upc;
	//document.getElementById('product_description_extra').value = r.shortDescription;
  document.getElementById('product_image1').src = r.img_url;
  document.getElementById('img1_link').href = r.img_url;
  document.getElementById('img_url1').value = r.img_url;
  document.getElementById('product_color').value = r.color;
	document.getElementById('brand_label').value = r.brand;
	document.getElementById('product_brand').value = r.brand;
	document.getElementById('product_Size').value = r.size;
	document.getElementById('response_message').innerHTML = '*Info Found via BrickSeek.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  if(r.price !== ''){
    add_suggested_price(r.price,'BrickSeek');
  }
  add_suggested_price('Google');
  format_ebay();
}


function di_parse(res,surl){
	var r = res.data.records[0];
	console.log(r);
	var nTitle = r.name.substring(0,80);
  //nTitle =  nTitle.replace(r.brandName,'');
	document.getElementById('product_title').value = nTitle;
	document.getElementById('product_code').value = r.upc;
	//document.getElementById('product_description_extra').value = r.shortDescription;
  for(var i = 0; i < 5; i++){
    if(r.imageURLs[i]){
      document.getElementById('product_image'+(i+1)+'').src = r.imageURLs[i];
      document.getElementById('img'+(i+1)+'_link').href = r.imageURLs[i];
      document.getElementById('img_url'+(i+1)+'').value = r.imageURLs[i];
    }
  }
  if(r.colors){
    document.getElementById('product_color').value = r.colors[0];
  }
	document.getElementById('brand_label').value = r.brand;
	//document.getElementById('product_brand').value = r.brand;
	//document.getElementById('product_Size').value = r.size;
	document.getElementById('product_msrp').value = r.prices[0].amountMax.toFixed(2);
	document.getElementById('response_message').innerHTML = '*Info Found via DataInfiniti.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  if(r.price !== ''){
    //add_suggested_price(r.price,'DataInfiniti');
  }
  add_suggested_price('Google');
  format_ebay();
}


function ra_parse(res){
  
	var r = res;
	console.log(r);
  if(r.source === 'upc_search_log DB'){
    
    //Set Ebay Categories...
    /*if(r.product_category_1){
      get_cats(1,'',r.product_category_1);
      sleep(1000);
    }*/
    //if(r.product_category_2){
      //document.getElementById('product_category_2').value = r.product_category_2;
      get_cats(2,r.product_category_1,r.product_category_2);
      sleep(500);
    //}
    //if(r.product_category_3){
      //document.getElementById('product_category_3').value = r.product_category_3;
      get_cats(3,r.product_category_2,r.product_category_3);
      sleep(500);
    //}
    //if(r.product_category_4){
      //document.getElementById('product_category_4').value = r.product_category_4;
      get_cats(4,r.product_category_3,r.product_category_4);
      sleep(500);
    //}
    
    //Set Ebay Store Cats...
    if(r.product_store_category_1){
      get_store_cats(1,'',parseInt(r.product_store_category_1));
      sleep(500);
    }
    if(r.product_store_category_2){
      get_store_cats(2,parseInt(r.product_store_category_1),parseInt(r.product_store_category_2));
      sleep(500);
    }
    
    //Get 81 Store Cats...
    if(r.product_81_store_category_1){
      get_81_store_cats(1,'',r.product_81_store_category_1);
      sleep(500);
    }
    if(r.product_81_store_category_2){
      get_81_store_cats(2,r.product_81_store_category_1,r.product_81_store_category_2);
      sleep(500);
    }
    if(r.product_81_store_category_3){
      get_81_store_cats(3,r.product_81_store_category_2,r.product_81_store_category_3);
      sleep(500);
    }
    if(r.product_81_store_category_4){
      get_81_store_cats(4,r.product_81_store_category_3,r.product_81_store_category_4);
      sleep(500);
    }
    
    if(r.product_title){
      var nTitle = r.product_title.substring(0,80);
    }else{
      var nTitle = r.description.substring(0,80);
    }
    nTitle =  nTitle.replace(r.brand,'');
    document.getElementById('product_title').value = nTitle;
    //Img1
    if(r.img_url1 !== ''){
      document.getElementById('product_image1').src = r.img_url1;
      document.getElementById('img1_link').href = r.img_url1;
      document.getElementById('img_url1').value = r.img_url1;
    }
    //Img2
    if(r.img_url2 !== ''){
      document.getElementById('product_image2').src = r.img_url2;
      document.getElementById('img2_link').href = r.img_url2;
      document.getElementById('img_url2').value = r.img_url2;
    }
    //Img3...
    if(r.img_url3 !== ''){
      document.getElementById('product_image3').src = r.img_url3;
      document.getElementById('img3_link').href = r.img_url3;
      document.getElementById('img_url3').value = r.img_url3;
    }
    //Img4...
    if(r.img_url4 !== ''){
      document.getElementById('product_image4').src = r.img_url4;
      document.getElementById('img4_link').href = r.img_url4;
      document.getElementById('img_url4').value = r.img_url4;
    }
    //Img5...
    if(r.img_url5 !== ''){
      document.getElementById('product_image5').src = r.img_url5;
      document.getElementById('img5_link').href = r.img_url5;
      document.getElementById('img_url5').value = r.img_url5;
    }
    
    //Setup dont_use array...
    var dont_use = [
      'source',
      'product_title',
      'product_category_1',
      'product_category_2',
      'product_category_3',
      'product_category_4',
      'new_img_url',
      'img_url1',
      'img_url2',
      'img_url3',
      'img_url4',
      'img_url5',
      'product_store_category_1',
      'product_store_category_2',
      'product_81_store_category_1',
      'product_81_store_category_2',
      'product_81_store_category_3',
      'product_81_store_category_4',
      'submit_to_store',
      'submit_to_ebay',
      'cur_cat',
      'cur_store_cat',
      'ebay_import',
      'import_ebay_listing',
      'env_mode',
      'api_key'
    ];
    //loop through remaining data...
    Object.keys(r).forEach(function(key) {
      if(dont_use.includes(key)){
         console.log(key+' Included...');
       }else{
         console.log(key+' Not Included...'+r[key]);
         if(document.getElementById(key)){
           document.getElementById(key).value = r[key];
         }else{
           setTimeout(function(){
             document.getElementById(key).value = r[key];
           },4000);
         }
       }
      //console.table('Key : ' + key + ', Value : ' + data[key]);
    });
    format_ebay();
    document.getElementById('loader').style.display = 'none';
    
  }else{
    
    if(r.title){
      var nTitle = r.title.substring(0,80);
    }else{
      var nTitle = r.description.substring(0,80);
    }
    nTitle =  nTitle.replace(r.brand,'');
    document.getElementById('product_title').value = nTitle;
    document.getElementById('product_code').value = r.upc;
    document.getElementById('product_description_extra').value = r.description;
    //Img1
    if(r.img1 !== ''){
      document.getElementById('product_image1').src = r.img1;
      document.getElementById('img1_link').href = r.img1;
      document.getElementById('img_url1').value = r.img1;
    }
    //Img2
    if(r.img2 !== ''){
      document.getElementById('product_image2').src = r.img2;
      document.getElementById('img2_link').href = r.img2;
      document.getElementById('img_url2').value = r.img2;
    }
    //Img3...
    if(r.img3 !== ''){
      document.getElementById('product_image3').src = r.img3;
      document.getElementById('img3_link').href = r.img3;
      document.getElementById('img_url3').value = r.img3;
    }
    //Img4...
    if(r.img4 !== ''){
      document.getElementById('product_image4').src = r.img4;
      document.getElementById('img4_link').href = r.img4;
      document.getElementById('img_url4').value = r.img4;
    }
    //Img5...
    if(r.img5 !== ''){
      document.getElementById('product_image5').src = r.img5;
      document.getElementById('img5_link').href = r.img5;
      document.getElementById('img_url5').value = r.img5;
    }
    //Other info...
    document.getElementById('product_color').value = r.color;
	  document.getElementById('brand_label').value = r.brand;
    document.getElementById('product_brand').value = r.brand;
    document.getElementById('product_Size').value = r.size;
    document.getElementById('product_msrp').value = r.price.toFixed(2);
    if(r.accurate == 'No'){
      document.getElementById('response_message').innerHTML = '*Info Found via Reseller App\'s Internal UPC Database';
    }else{
      document.getElementById('response_message').innerHTML = '*Info Found via Reseller App\'s Internal UPC Database <button type="button" class="btn btn-danger btn-sm" onclick="flag_upc('+r.upc+',this);">Mark Inaccurate</button>';
    }
    document.getElementById('loader').style.display = 'none';
    if(r.price !== ''){
      add_suggested_price(r.price,'Reseller App');
    }
    add_suggested_price('Google');
    format_ebay();
    
  }
  
}


function flag_upc(upc,elem){
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
      console.log(this.responseText);
      var r = JSON.parse(this.responseText);
      if(r.response == 'GOOD'){
        alert(r.message);
        elem.remove();
        window.location = "?upc_code="+upc;
      }else{
        alert('There was an error flagging this UPC Code...');
      }
      
    }
  }
  xmlhttp.open("GET","assets/upc-data/flag-upc.php?upc="+upc,true);
  xmlhttp.send();
}
