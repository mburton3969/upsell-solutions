function format_ebay(){
  //Get Fields...
  var ptitle = document.getElementById('product_title').value;
  var psection = document.getElementById('product_section').value;
  var pbrand = document.getElementById('product_brand').value;
  var pcolor = document.getElementById('product_color').value;
  var psize = '';
  if(document.getElementById('product_Size')){
    var psize = document.getElementById('product_Size').value;
  }
  var pmaterial = document.getElementById('product_material').value;
  
  //Format the eBay Fields...
  var ebay_title = psection+' '+pbrand+' '+ptitle+' '+pcolor+' '+psize;
  var ebay_desc = psection+' '+pbrand+' '+ptitle+' '+pcolor+' '+psize+'\r\n'+'\r\n'+pmaterial;
  
  //Check Title String Length...
  //alert(ebay_title.length);
  if(ebay_title.length > 80){
    document.getElementById('submit_btn').disabled = true;
    document.getElementById('submit_btn').innerHTML = '[Fix Ebay Title (Too Long)]';
    var nTitle1 = ebay_title.substring(0,80);
    var nTitle2 = ebay_title.substring(80);
    ebay_title = '<u>Ebay Title:</u> '+nTitle1+'<span style="color:red;font-weight:bold;">'+nTitle2+'</span>';
    alert('The eBay Title is currently longer than the maximum 80 characters allowed for a listing!');
  }else{
    document.getElementById('submit_btn').disabled = false;
    document.getElementById('submit_btn').innerHTML = 'Submit To Ebay';
  }
  
  //Set Title...
  document.getElementById('product_title_display').innerHTML = ebay_title;
  
  //Set Description...
  document.getElementById('product_description').value = ebay_desc;
  
  //Set Description Preview...
  var d = document.getElementById('product_description').value;
  var de = document.getElementById('product_description_extra').value.replace(/\r?\n/g, "<br />");
  var df = document.getElementById('product_description_footer').value;
  var df_img = '<img src="https://beta.reseller-solutions.com/assets/imgs/81-logo.png" style="width:500px;" />';
  document.getElementById('desc_preview').innerHTML = d+'</br></br>'+de+'</br></br>'+df+'</br>'+df_img;
}