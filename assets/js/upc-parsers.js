function de_parse(r,surl){
	document.getElementById('product_title').value = r.description;
	document.getElementById('product_description').value = r.description;
	document.getElementById('product_label').value = '';
	document.getElementById('product_brand').value = r.brand;
	//document.getElementById('product_category').value = '';
	document.getElementById('product_code').value = r.upc_code;
	document.getElementById('product_condition').value = '';
	document.getElementById('product_image1').src = r.image;
  document.getElementById('img1_link').href = r.image;
	document.getElementById('img_url1').value = r.image;
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('response_message').innerHTML = '*Info Found via Digit-Eyes.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
}


function bl_parse(res,surl){
	var r = res.products[0];
	console.log(r);
	document.getElementById('product_title').value = r.product_name;
	document.getElementById('product_label').value = r.label;
	//document.getElementById('product_category').value = r.category;
	document.getElementById('product_code').value = r.barcode_number;
	document.getElementById('product_condition').value = '';
	document.getElementById('product_image1').src = r.images[0];
  document.getElementById('img1_link').href = r.images[0];
	document.getElementById('img_url1').value = r.images[0];
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('response_message').innerHTML = '*Info Found via Barcodelookup.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
}


function upc_parse(res,surl){
	var r = res.items[0];
	console.log(r);
	document.getElementById('product_title').value = r.title;
	document.getElementById('product_label').value = '';
	//document.getElementById('product_category').value = '';
	document.getElementById('product_code').value = r.upc;
	document.getElementById('product_condition').value = '';
	document.getElementById('product_image1').src = r.images[0];
  document.getElementById('img1_link').href = r.images[0];
	document.getElementById('img_url1').value = r.images[0];
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('response_message').innerHTML = '*Info Found via upcitemdb.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
}


function wm_parse(res,surl){
	var r = res.items[0];
	console.log(r);
	document.getElementById('product_title').value = r.title;
	document.getElementById('product_label').value = '';
	document.getElementById('product_category').value = '';
	document.getElementById('product_code').value = r.upc;
	document.getElementById('product_condition').value = '';
	document.getElementById('product_image1').src = r.images[0];
	document.getElementById('img_url1').value = r.images[0];
  document.getElementById('img1_link').href = r.images[0];
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('response_message').innerHTML = '*Info Found via walmart.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
}





