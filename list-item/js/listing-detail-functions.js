function get_item_details(iid){
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

      console.log(this.responseText);
      var r = JSON.parse(this.responseText);
      if (r.response == 'GOOD') {

        parse_ebay_data(r.item_data);

      }

    }
  }
  xmlhttp.open('GET', "assets/ebay/get-ebay-listing-by-id.php?iid="+iid, true);
  xmlhttp.send();
}


function parse_ebay_data(data){
  var r = data;
  //Get Item Specifics...
  var brand;
  var UPC;
  var color;
  var size;
  var material;
  for(var ii = 0; ii < r.ItemSpecifics.NameValueList.length; ii++){
    var b = r.ItemSpecifics.NameValueList[ii];
    if(b.Name === 'Brand'){
      brand = b.Value;
      console.log('Brand: '+brand);
    }
    if(b.Name === 'UPC'){
      UPC = b.Value;
      console.log('UPC: '+UPC);
    }
    if(b.Name === 'Color'){
      color = b.Value;
      console.log('color: '+color);
    }
    if(b.Name === 'Size'){
      size = b.Value;
      console.log('size: '+size);
    }
    if(b.Name === 'Material'){
      material = b.Value;
      console.log('material: '+material);
    }
    
  }
	console.log(r);
	var nTitle = r.Title.substring(0,80);
  nTitle =  nTitle.replace(brand,'');
	document.getElementById('product_title').value = nTitle;
	document.getElementById('product_label').value = r.SKU;
	document.getElementById('product_code').value = UPC;
	document.getElementById('product_description_extra').value = r.shortDescription;
  for(var i = 0; i < 5; i++){
    if(r.PictureURL[i]){
      document.getElementById('product_image'+(i+1)+'').src = r.PictureURL[i];
      document.getElementById('img'+(i+1)+'_link').href = r.PictureURL[i];
      document.getElementById('img_url'+(i+1)+'').value = r.PictureURL[i];
    }
  }
	document.getElementById('product_price').value = r.CurrentPrice.value;
  document.getElementById('product_color').value = color;
	document.getElementById('product_quantity').value = r.Quantity;
	document.getElementById('product_brand').value = brand;
	document.getElementById('product_Size').value = size;
	document.getElementById('product_material').value = material;
	//document.getElementById('response_message').innerHTML = '*Info Found via walmart.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  //get_ebay_item_prices(r.upc);
  format_ebay();
}