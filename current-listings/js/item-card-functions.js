function get_current_selling(){
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
            
            console.log('DONE');

          }
          
        }
      }
      xmlhttp.open('GET', "assets/ebay/get-ebay-current-selling.php", true);
      xmlhttp.send();
}


(function(){
    get_current_selling();
})();