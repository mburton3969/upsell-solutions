function validate_form(){
  var form = document.getElementById('lister_form');
  if(form.checkValidity()){
    check_product();
    sessionize_request();
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
            toast_alert('ERROR',r.error,'top-right','error');
            return;
          }
        }else{
          toast_alert('ERROR','An Unknown Error Occurred...','top-right','error');
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
          save_upc_data('Yes','New Item');
        }else if(r.response === 'ERROR'){
          toast_alert('ERROR',r.error,'top-right','error');
          return;
        }else{
          toast_alert('ERROR','An Unknown Error Occurred...','top-right','error');
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
    save_upc_data('Yes','Item Exists. Current Qty: '+qty);
  }
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {//Call a function when the state changes.
      if(xhr.readyState == 4 && xhr.status == 200) {
        var r = JSON.parse(this.responseText);
        if(r.response === 'GOOD'){
          toast_alert('Successful Listing!','Item listed successfully!','top-right','success');
          document.getElementById('loader').style.display = 'inline';
          setTimeout(function(){
            window.location = 'index.php';
          },1000);
        }else if(r.response === 'ERROR'){
          toast_alert('ERROR',r.error,'top-right','error');
          return;
        }else{
          toast_alert('ERROR','An Unknown Error Occurred...','top-right','error');
          return;
        }
      }
  }
  xhr.open('POST', url, true);
  //Send the proper header information along with the request
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send(params); 
}


function save_upc_data(listed,message){
  var url = 'assets/upc-data/add-upc-data.php';
  var upc = document.getElementById('product_code').value;
  var params = $('#lister_form').serialize();
  params += "&listed="+listed+"&message="+message+"&upc="+upc;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {//Call a function when the state changes.
      if(xhr.readyState == 4 && xhr.status == 200) {
          var r = JSON.parse(this.responseText);
        if(r.response === 'GOOD'){
          toast_alert('Success','UPC Data saved successfully!','top-right','success');
        }else if(r.response === 'ERROR'){
          toast_alert('ERROR','Error saving UPC Data...','top-right','error');
          return;
        }else{
          toast_alert('ERROR','An Unknown Error Occurred in save_upc_data...','top-right','error');
          return;
        }
      }
  }
  xhr.open('POST', url, true);
  //Send the proper header information along with the request
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send(params); 
}


function sessionize_request(){
  var url = 'assets/upc-data/sessionize-request-data.php';
  var params = $('#lister_form').serialize();
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {//Call a function when the state changes.
      if(xhr.readyState == 4 && xhr.status == 200) {
        var r = JSON.parse(this.responseText);
        if(r.response === 'GOOD'){
          enable_similar_btn();
          toast_alert('Success',r.message,'top-right','success');
        }else if(r.response === 'ERROR'){
          toast_alert('ERROR','Error saving UPC Data...','top-right','error');
          return;
        }else{
          toast_alert('ERROR','An Unknown Error Occurred in sessionize_request...','top-right','error');
          return;
        }
      }
  }
  xhr.open('POST', url, true);
  //Send the proper header information along with the request
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send(params); 
}


function enable_similar_btn(){
  if(document.getElementById('similar_btn')){
    document.getElementById('similar_btn').remove();
  }
  var btn = document.createElement('a');
  btn.id = 'similar_btn';
  btn.setAttribute('type','button');
  btn.setAttribute('class','btn btn-primary btn-sm');
  btn.setAttribute('style','margin-left:25px;');
  btn.href = "index.php?retry=Yes";
  btn.text = 'List Similar Item';
  document.getElementById('page_title_bar').appendChild(btn);
}