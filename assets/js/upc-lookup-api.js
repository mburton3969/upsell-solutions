//Global Variables...
var de_apikey = '//xu6oxn1fAq';
var auth_key = 'Nk07Z4j6m5Aq3Th1';
var signature = '';

var bl_apikey = 'by9mvc1ud63gvzw584xrs6rkaisosy';

var ud_apikey = '2e514306059046cf75e01e0010bce0ee';

var wm_apikey = 'rfjbc7str5mjyf6ta4ed76jf';

function lookup_upc(e,upc){
  if(e.keyCode !== 13){
    //console.log('NOT ENTER...');
    return;
  }
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
      console.log(this.responseText);
      var response = JSON.parse(this.responseText);

      var trip = false;
      var de_r = JSON.parse(response.de_data);
      var bl_r = JSON.parse(response.bl_data);
      var wm_r = JSON.parse(response.wm_data);
      var upc_r = JSON.parse(response.upc_data);

      if(trip === false){
        if(de_r.return_code === '000'){
          de_parse(de_r);
          trip = true;
        }else{
          console.log('Digit Eyes Return Code Error...');
        }
      }

      if(trip === false){
        if(bl_r !== false){
          bl_parse(bl_r);
          trip = true;
        }else{
          console.log('No Barcode Lookup Results...');
        }
      }


      if(trip === false){
        if(upc_r.code === 'OK'){
          upc_parse(upc_r);
          trip = true;
        }else{
          console.log('No UPC Database Results...');
        }
      }


      if(trip === false){
        if(wm_r !== false){
          wm_parse(wm_r);
          trip = true;
        }else{
          console.log('No Walmart Results...');
        }
      }


    }
  }
  xmlhttp.open("GET","assets/php/upc-lookup.php?upc="+upc+"&auth_key="+auth_key+"&bl_apikey="+bl_apikey+"&de_apikey="+de_apikey+"&ud_apikey="+ud_apikey+"&wm_apikey="+wm_apikey,true);
  xmlhttp.send();
}




