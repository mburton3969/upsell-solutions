(function add_queue_btn(){
  var btn = document.createElement('button');
  btn.setAttribute('type','button');
  btn.setAttribute('class','btn btn-success');
  btn.setAttribute('onclick','get_current_selling();');
  btn.innerHTML = 'Add 6 Items to My Queue';
  document.getElementById('page-header').appendChild(btn);
})();


(function get_queued_items(){
  document.getElementById('loader').style.display = 'inline';
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
        for(var i = 0; i < r.item.length; i++){
          create_card_2(r.item[i]);
        }
        document.getElementById('loader').style.display = 'none';

      }

    }
  }
  xmlhttp.open('GET', "current-listings/php/get-queued-items.php", true);
  xmlhttp.send();
})();