function urlEncode(url){
		url = url.replace(/&/g, '%26'); 
		url = url.replace(/#/g, '%23');
		return url;
	}

function toast_alert(title,mess,pos,mode){
  $.toast({
		heading: title,
		text: mess,
		position: pos,
		loaderBg:'#f2b701',
		icon: mode,//success, error, info, warning...
		hideAfter: 3500, 
		stack: 6
	});
}


$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

function init_tooltips(){
  $('[data-toggle="tooltip"]').tooltip();
}

//Delay Function...
function sleep(milliseconds) {
  console.warn('Sleeping For '+milliseconds+' milliseconds...');
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}


function get_api_usage(){
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
      for(var i = 0; i < r.data.ApiAccessRule.length; i++){
        var x = r.data.ApiAccessRule[i];
        if(x.CallName === 'ApplicationAggregate'){
          document.getElementById('api_calls').innerHTML = x.DailyUsage+' / '+x.DailyHardLimit;
        }
      }
      
    }
  }
  xmlhttp.open('GET', "assets/ebay/get-ebay-api-usage.php", true);
  xmlhttp.send();
}

//get_api_usage();

setInterval(function(){
  //get_api_usage();
},30000);