function de_parse(r,surl){
	document.getElementById('product_description_extra').value = r.description;
	document.getElementById('product_label').value = '';
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
    document.getElementById('product_brand').value = r.brand;
  }else{
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
	document.getElementById('product_brand').value = r.brand;
	document.getElementById('product_image1').src = r.images[0];
  document.getElementById('img1_link').href = r.images[0];
	document.getElementById('img_url1').value = r.images[0];
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('product_Size').value = r.size;
	document.getElementById('product_color').value = r.color;
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
	document.getElementById('product_brand').value = r.brandName;
	document.getElementById('product_Size').value = r.size;
	document.getElementById('response_message').innerHTML = '*Info Found via walmart.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  get_ebay_item_prices(r.upc);
  format_ebay();
}





