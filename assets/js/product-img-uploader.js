
function uploadProdImg() {
  
  var form = document.getElementById('img-form');
  var fileInput = document.getElementById('img-file');
  var file = fileInput.files[0];
  var formData = new FormData();
  formData.append('file', file);
  
  //UPC Code...
  var iUPC = document.getElementById('product_code').value;
  if(iUPC === ''){
    var iUPC = document.getElementById('upc_code').value;
    if(iUPC === ''){
      alert('The barcode must be entered in order to add images...');
      //Empty the File Input...
      document.getElementById('img-file').value = '';
      return;
    }
  }
  formData.append('img_upc',iUPC);

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
        //document.getElementById('img_preview').src = r.img_url;
        document.getElementById('close-img-modal').click();
        document.getElementById('new_img_url').value = r.img_url;
        //Empty the File Input...
        document.getElementById('img-file').value = '';
      }
      
    }
  }
  xmlhttp.open('POST', form.getAttribute('action'), true);
  //xmlhttp.setRequestHeader("Content-Type", "multipart/form-data");
  xmlhttp.send(formData);

  //return false; // To avoid actual submission of the form
}


