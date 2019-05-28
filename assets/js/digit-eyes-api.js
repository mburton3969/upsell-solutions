//Global Variables...
var de_apikey = '//xu6oxn1fAq';
var auth_key = 'Nk07Z4j6m5Aq3Th1';
var signature = '';

var bl_apikey = 'by9mvc1ud63gvzw584xrs6rkaisosy';

var ud_apikey = '2e514306059046cf75e01e0010bce0ee';

function lookup_upc(upc){
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
      console.log(this.responseText);
      document.getElementById('result').innerHTML = this.responseText;
      //console.log('SIGN: '+this.responseText);
      //signature = this.responseText;
      //get_details(upc,signature);
      //var result = JSON.parse(this.responseText);
      //var r = result.products;

    }
  }
  xmlhttp.open("GET","assets/php/get-signature.php?upc="+upc+"&auth_key="+auth_key+"&bl_apikey="+bl_apikey+"&de_apikey="+de_apikey+"&ud_apikey="+ud_apikey,true);
  xmlhttp.send();
}

/*function get_details(upc){

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
      if(r.return_code === '000'){
      	console.log('Sucess!');
      }else{
      	console.warn('API Return Code: '+r.return_code);
      }
      
    }
  }
  xmlhttp.open("GET","https://api.barcodelookup.com/v2/products?barcode="+upc+"&formatted=y&key="+bl_apikey,true);
  xmlhttp.withCredentials = true;
  xmlhttp.send();
}*/


