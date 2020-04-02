function get_ebay_item_prices(upc_code){
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
        for(var i = 0; i < r.prices.length; i++){
          r.prices.sort();
          var x = r.prices[i];
          //GET PRICE FUNCTION HERE
          add_suggested_price(x,'eBay');
        }
      }else if(r.response === 'ERROR'){
        var sp = document.getElementById('suggested_prices');
        sp.innerHTML = '';
        var em = document.createElement('span');
        em.setAttribute('style','color:red;font-weight:bold;');
        var sTitle = document.getElementById('product_title').value;
        var sURL = 'https://www.google.com/search?q='+sTitle;
        var ex = '&oq=Gildan+Mens+Dyed+Assorted+Boxer+Brief+Underwear%2C+5-pack';
        em.innerHTML = 'No Suggested Pricing Found...';
        sp.appendChild(em);
        add_suggested_price('Google');
        console.warn(r.error_data[0].error_type+': '+r.error_data[0].error_message);
      }
      
    }
  }
  xmlhttp.open("GET","assets/php/get-ebay-item-prices.php?upc_code="+upc_code,true);
  xmlhttp.send();
}


function add_suggested_price(price,location){
  var sp = document.getElementById('suggested_prices');
  //sp.innerHTML = '';
  if(price === 'Google'){
    var sTitle = document.getElementById('product_title').value;
    var sURL = 'https://www.google.com/search?q='+escape(sTitle);
    var po = document.createElement('button');
    po.setAttribute('type','button');
    po.setAttribute('class','btn btn-warning btn-sm');
    po.setAttribute('style','margin:5px;');
    po.setAttribute('onclick','window.open(\''+sURL+'\',\'_blank\');');
    po.innerHTML = '<small>Search Google</small>';
    sp.appendChild(po);
  }else{
    //Create Price Option...
    var po = document.createElement('button');
    po.setAttribute('type','button');
    po.setAttribute('class','btn btn-primary btn-sm');
    po.setAttribute('style','margin:5px;');
    po.setAttribute('onclick','set_price_value('+price+');');
    po.innerHTML = '<small>$'+price+' ['+location+']</small>';
    sp.appendChild(po);
  }
}

function set_price_value(price){
  document.getElementById('product_price').value = price;
}