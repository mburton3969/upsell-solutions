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
        
        //$("#submit_to_ebay").attr("checked", false);
        //$('#submit_to_ebay').click();
        //$("#submit_to_ebay").attr("disabled", true);
        parse_ebay_data(r.item_data);

      }

    }
  }
  xmlhttp.open('GET', "assets/ebay/get-ebay-listing-by-id.php?iid="+iid, true);
  xmlhttp.send();
}


function parse_ebay_data(data){
  var r = data;
  document.getElementById('ebay_import').value = 'Yes';
  //Get Item Specifics...
  var brand;
  var UPC;
  var color;
  var size;
  var material;
  var size_type;
  var style;
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
    if(b.Name === 'Size Type'){
      size_type = b.Value;
      console.log('Size Type: '+size_type);
    }
    if(b.Name === 'Style'){
      style = b.Value;
      console.log('Size Type: '+style);
    }
    
  }
	console.log(r);
	var nTitle = r.Title.substring(0,80);
  nTitle =  nTitle.replace(brand,'');
  var description = r.Description.replace('<p>Thank you for shopping with 81 Outfitters. With our top rating and consistently lowest prices, we look forward to exceeding your expectations. </p><img src="https://beta.reseller-solutions.com/assets/imgs/81-logo.png" style="width:500px;" />','');
  //description = description.replace(/<p>/g,'');
  //description = description.replace(/<\/p>/g,'');
  description = description.replace(/<br \/>/g,'');
  if(description.includes('</p>')){
    var descs = description.split('</p>');
    document.getElementById('product_description_extra').value = descs[1].replace(/<p>/g,'');
  }else{
    var descs = description.replace( /<br>/g, '-xxx-');
    descs = descs.replace( /(<([^>]+)>)/ig, '');
    descs = descs.replace(/<p>/g,'');
    descs = descs.replace(/&nbsp;/g,' ');
    descs = descs.replace(/-xxx-/g, '\r\n\r\n');
    document.getElementById('product_description_extra').value = descs;
  }
  
	document.getElementById('product_title').value = nTitle;
	document.getElementById('product_label').value = r.SKU;
	document.getElementById('product_code').value = UPC;
	//document.getElementById('product_description_extra').value = descs[1].replace(/<p>/g,'');
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
  get_ebay_cats(r.PrimaryCategoryID);//Set Ebay Categories...
  sleep(1500);
  getItemSpecifics(r.PrimaryCategoryID);
  $('#item_specifics').bind('DOMSubtreeModified', function(){
    if(document.getElementById('product_Size_Type')){
      document.getElementById('product_Size_Type').value = size_type;
    }
    if(document.getElementById('product_Style')){
      document.getElementById('product_Style').value = style;
    }
  });
  
	//document.getElementById('response_message').innerHTML = '*Info Found via walmart.com [<a href="'+surl+'" target="_blank">View Source</a>]';
  document.getElementById('loader').style.display = 'none';
  //get_ebay_item_prices(r.upc);
  format_ebay();
}


function get_ebay_cats(cid){
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
        var timer = 500;
        for(var iii = 1; iii <= r.max_cat_level; iii++){
          console.log('Category Test: '+r.cats[iii]);
          timer = timer + 500;
          
            if(iii === 1){
              console.warn('pre-pre-check: Base Level');
              get_cats(iii,'bypass');
            }else{
                console.warn('pre-pre-check: '+(iii)+','+r.cats[iii-1]+','+r.cats[iii]);
                get_cats((iii),r.cats[iii-1],r.cats[iii]);
                sleep(500);
                document.getElementById('cur_cat').value = r.cats[iii];
                console.log('cur_cat set to: '+r.cats[iii]);
            }
            
        }

      }

    }
  }
  xmlhttp.open('GET', "list-item/php/get-ebay-categories.php?cid="+cid, true);
  xmlhttp.send();
}