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