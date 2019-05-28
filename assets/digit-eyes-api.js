//Global Variables...
var apikey = '//xu6oxn1fAq';
var auth_key = 'Nk07Z4j6m5Aq3Th1';
var signature = '';


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
      //console.log('SIGN: '+this.responseText);
      //signature = this.responseText;
      //get_details(upc,signature);
    }
  }
  xmlhttp.open("GET","assets/php/get-signature.php?upc="+upc+"&auth_key="+auth_key+"&apikey="+apikey,true);
  xmlhttp.send();
}

/*function get_details(upc,signature){

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
  xmlhttp.open("GET","https://www.digit-eyes.com/gtin/v2_0/?upcCode="+upc+"&field_names=all&language=en&app_key="+apikey+"&signature="+signature,true);
  xmlhttp.send();
}*/


