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
  
  //Set Description...
  document.getElementById('product_description').value = ebay_desc;
}