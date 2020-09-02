function validate_form(){
  var form = document.getElementById('lister_form');
  if(form.checkValidity()){
    check_product();
    return false;
  }else{
    //return;
    console.log('Invalid Form');
    return false;
  }
}

function check_product(){
  var sku = document.getElementById('product_code').value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         // Typical action to be performed when the document is ready:
         var r = JSON.parse(this.responseText);
        if(r.response === 'GOOD'){
          update_inventory(r.quantity);
        }else if(r.response === 'ERROR'){
          if(r.error === 'not found'){
            list_product();
          }else{
            toast_alert('ERROR',r.error,'bottom-right','error');
            return;
          }
        }else{
          toast_alert('ERROR','An Unknown Error Occurred...','bottom-right','error');
          return;
        }
      }
  };
  xhttp.open("GET", "assets/sellbrite/get-product.php?sku="+sku, true);
  xhttp.send();
}

function list_product(){
  var url = 'assets/sellbrite/create-product.php';
  var params = $('#lister_form').serialize();
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {//Call a function when the state changes.
      if(xhr.readyState == 4 && xhr.status == 200) {
        var r = JSON.parse(this.responseText);
        if(r.response === 'GOOD'){
          update_inventory();
        }else if(r.response === 'ERROR'){
          toast_alert('ERROR',r.error,'bottom-right','error');
          return;
        }else{
          toast_alert('ERROR','An Unknown Error Occurred...','bottom-right','error');
          return;
        }
      }
  }
  xhr.open('POST', url, true);
  //Send the proper header information along with the request
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send(params); 
}


function update_inventory(qty){
  var url = 'assets/sellbrite/update-inventory.php';
  var params = $('#lister_form').serialize();
  if(qty){
    params += "&cur_qty="+qty;
  }
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {//Call a function when the state changes.
      if(xhr.readyState == 4 && xhr.status == 200) {
        var r = JSON.parse(this.responseText);
        if(r.response === 'GOOD'){
          toast_alert('Successful Listing!',r.name+' listed successfully!','bottom-right','success');
          window.location = 'index.php';
        }else if(r.response === 'ERROR'){
          toast_alert('ERROR',r.error,'bottom-right','error');
          return;
        }else{
          toast_alert('ERROR','An Unknown Error Occurred...','bottom-right','error');
          return;
        }
      }
  }
  xhr.open('POST', url, true);
  //Send the proper header information along with the request
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send(params); 
}


//Maybe add this to the existing upc_lookup() function????????

//UPC Code pre-check for SellBrite existence...
function sellbrite_precheck(){
  
}