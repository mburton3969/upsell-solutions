//Global Variables...
var shopify_products = [];
var untagged_products = [];
var to_be_tagged = [];
var tagged_items = [];
var page_link = 'default';
var old_data_set = [];
var no_result_items = [];
var trip;

async function init_tag_sync(){
  //document.getElementById('sync-tag-loader').style.display = 'inherit';
  //$('#syncTagsModal').modal('toggle');
  //await setup_modal();
  var ii = 1;
  while(page_link !== '' && page_link !== 'STOP'){
    if(ii > 19){
      return;
    }
    if(page_link === 'default'){
      page_link = '';
      old_data_set[0] = [];
      old_data_set[0].title = 'default';
      old_data_set[0].variants = [];
      old_data_set[0].variants.barcode = '999999';
    }
    page_link = await get_shopify_products(page_link);
    console.log('Shopify Products: '+shopify_products.length);
    console.log(shopify_products);
    console.log('Link: '+page_link);
    ii++;
  }
  shopify_products.forEach(function(d){
      var tags_array = d.tags.split(',');
      tags_array.forEach(function(t){
        console.log(t);
        if(t.includes('Brand_')){
          if(t === 'Brand_'){
            console.log('Empty Value...');
            untagged_products.push(d);
            document.getElementById('sb_need_tags').innerHTML = untagged_products.length;
          }else{
            console.log('Has Value...');
          }
        }else{
          //console.warn('Brand not found');
        }
      });
  });
  for(var i = 0; i < untagged_products.length; i++){
    await add_tags(untagged_products[i]);
    document.getElementById('sb_updated').innerHTML = tagged_items.length;
  }
  console.log('Process Completed...');
}


function get_shopify_products(params){
  return new Promise((resolve,reject) => {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           // Typical action to be performed when the document is ready:
           var r = JSON.parse(this.responseText);
          if(r.response === 'GOOD'){
            if((r.products[0].title === old_data_set[0].title) && (r.products[0].variants.barcode === old_data_set[0].variants.barcode)){
              console.log('Matched to old link...');
              resolve('STOP');
            }else{
              old_data_set = r.products;
              r.products.forEach(function(d){
                shopify_products.push(d);
              });
              resolve(r.pagination_link);
            }
            document.getElementById('sb_loaded').innerHTML = shopify_products.length;
          }else{
            toast_alert('ERROR',r.message,'top-right','error',false);
            reject(new Error("Error: "+r.message));
          }
        }
    };
    xhttp.open("GET", "../../shopify/get-all-products.php?page_info="+params, true);
    xhttp.send();
  });
}


function add_tags(d){
  return new Promise((resolve,reject) => {
    console.log(d.variants);
    var url = '../../shopify/retro-update-product-tags.php';
    var params = 'upc_code='+d.variants[0].barcode+'&product_id='+d.id;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {//Call a function when the state changes.
        if(xhr.readyState == 4 && xhr.status == 200) {
          //Do Something...
          var r = JSON.parse(this.responseText);
          if(r.response === 'GOOD'){
            console.log(r);
            tagged_items.push(d);
            resolve();
          }else if(r.response === 'EMPTY'){
            no_result_items.push(d);
            console.log('No Tags Found...');
            resolve();
          }else{
            //If error occurs...
            reject(new Error('error message'));
          }
        }
    }
    xhr.open('POST', url, true);
    //Send the proper header information along with the request
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params); 
  });
}


function add_sync_error(err){
  var el = document.getElementById('sync_error_list');
  var i = document.createElement('li');
  i.innerHTML = err;
  el.appendChild(i);
}