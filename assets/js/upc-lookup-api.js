//Global Variables...
//var de_apikey = '/xMWqdrXkwY1';//Demo Account
var de_apikey = '/4elLY%2BpIk2S';//Live Account

//var auth_key = 'Jw52V2u2x9Mm6Kb0';//Demo Account
var auth_key = 'Ws05M3r7w9Bt3Yu1';//Live Account
var signature = 'rE5vp\/HdpLZLGG+mlYluip2bIpY=';

//var bl_apikey = 'by9mvc1ud63gvzw584xrs6rkaisosy';//Old - michael@ignition-innovations.com
//var bl_apikey = 'v2f01t08qidk97sd9bmunttekq8gzr';//Old Test Account michael@burtonsolution.com
var bl_apikey = 'nvr38f3cdml6nlwjqqa3vx21cbbrqn';


var ud_apikey = '2e514306059046cf75e01e0010bce0ee';

var wm_apikey = 'rfjbc7str5mjyf6ta4ed76jf';

function lookup_upc(e,upc){
  if(e.keyCode !== 13){
    if(e === 'BYPASS'){
      //continue...
      document.getElementById('upc_code').value = upc;
    }else{
      //console.log('NOT ENTER...');
      return;
    }
  }else{
    upc = upc.trim();
  }
  //Move space from beginning and end of the UPC code...
  //upc = upc.trim();
  document.getElementById('loader').style.display = 'inline';
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

      if(trip === false){
        if(de_r.return_code && de_r.return_code !== '4' && de_r.return_code !== '001'){
          de_parse(de_r,response.de_url);
          trip = true;
        }else{
          console.log('Digit Eyes Return Code Error...');
          if(response.bl_data !== ''){
            var bl_r = JSON.parse(response.bl_data);
          }else{
            var bl_r = false;
          }
        }
      }

      if(trip === false){
        if(bl_r !== false){
          bl_parse(bl_r,response.bl_url);
          trip = true;
        }else{
          console.log('No Barcode Lookup Results...');
          if(response.upc_data !== ''){
            var upc_r = JSON.parse(response.upc_data);
          }else{
            var upc_r = false;
          }
        }
      }


      if(trip === false){
        if(upc_r.code === 'OK' && upc_r !== false && upc_r.total !== 0){
          upc_parse(upc_r,response.upc_url);
          trip = true;
        }else{
          console.log('No UPC Database Results...');
          if(response.wm_data !== ''){
            var wm_r = JSON.parse(response.wm_data);
          }else{
            var wm_r = false;
          }
        }
      }


      if(trip === false){
        if(wm_r !== false){
          wm_parse(wm_r,response.wm_url);
          trip = true;
        }else{
          console.log('No Walmart Results...');
          if(response.bs_data !== ''){
            var bs_r = JSON.parse(response.bs_data);
          }else{
            var bs_r = false;
          }
        }
      }
      
      
      if(trip === false){
        if(bs_r !== false){
          bs_parse(bs_r,response.bs_url);
          trip = true;
        }else{
          console.log('No BrickSeek Results...');
          if(response.di_data !== ''){
            var di_r = JSON.parse(response.di_data);
          }else{
            var di_r = false;
          }
        }
      }
      
      
      if(trip === false){
        if(di_r !== false){
          di_parse(di_r,response.di_url);
          trip = true;
        }else{
          console.log('No DataInfiniti Results...');
          if(response.ra_data !== ''){
            var ra_r = JSON.parse(response.ra_data);
          }else{
            var ra_r = false;
          }
        }
      }
      
      if(trip === false){
        if(ra_r !== false){
          ra_parse(ra_r);
          trip = true;
        }else{
          console.log('No Reseller App Results...');
        }
      }
      
      
      
      //No Results Found...
      if(trip === false){
        document.getElementById('loader').style.display = 'none';
        //Add "Search BrickSeek" button...
        var em = document.getElementById('response_message');
        em.innerHTML = '';
        var btn = document.createElement('button');
        btn.setAttribute('type','button');
        btn.setAttribute('class','btn btn-primary');
        btn.setAttribute('onclick','window.open("https://brickseek.com/products/?search='+upc+'","_blank");');
        btn.innerHTML = 'Search BrickSeek.com';
        em.appendChild(btn);
        //Title, Message, Button Text...
        throwError("No Results Found!","There were no results found for the UPC code entered. Please Manually enter the item details","Enter Manually");
      }


    }
  }
  xmlhttp.open("GET","assets/php/upc-lookup.php?upc="+upc+"&auth_key="+auth_key+"&bl_apikey="+bl_apikey+"&de_apikey="+de_apikey+"&ud_apikey="+ud_apikey+"&wm_apikey="+wm_apikey,true);
  xmlhttp.send();
}




