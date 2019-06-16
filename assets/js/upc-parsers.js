function de_parse(r){
	document.getElementById('product_title').value = r.description;
	document.getElementById('product_label').value = '';
	document.getElementById('product_category').value = '';
	document.getElementById('product_code').value = r.upc_code;
	document.getElementById('product_condition').value = '';
	document.getElementById('product_image1').src = r.image;
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('response_message').innerHTML = '*Info Found via Digit-Eyes.com';
  document.getElementById('loader').style.display = 'none';
}


function bl_parse(res){
	var r = res.products[0];
	console.log(r);
	document.getElementById('product_title').value = r.product_name;
	document.getElementById('product_label').value = r.label;
	document.getElementById('product_category').value = r.category;
	document.getElementById('product_code').value = r.barcode_number;
	document.getElementById('product_condition').value = '';
	document.getElementById('product_image1').src = r.images[0];
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('response_message').innerHTML = '*Info Found via Barcodelookup.com';
  document.getElementById('loader').style.display = 'none';
}


function upc_parse(res){
	var r = res.items[0];
	console.log(r);
	document.getElementById('product_title').value = r.title;
	document.getElementById('product_label').value = '';
	document.getElementById('product_category').value = '';
	document.getElementById('product_code').value = r.upc;
	document.getElementById('product_condition').value = '';
	document.getElementById('product_image1').src = r.images[0];
	document.getElementById('product_price').value = '';
	document.getElementById('product_quantity').value = '';
	document.getElementById('response_message').innerHTML = '*Info Found via upcitemdb.com';
  document.getElementById('loader').style.display = 'none';
}