//Global Variables...
var shopify_products;
var untagged_products;
var to_be_tagged = [];

async function init_tag_sync(){
  document.getElementById('sync-tag-loader').style.display = 'inherit';
  $('#syncTagsModal').modal('toggle');
  await setup_modal();
  await get_shopify_products();
  console.log('Shopify Products:');
  console.log(shopify_products);
  await get_untagged_products();
  console.log('Untagged Products:');
  console.log(untagged_products);
  document.getElementById('sync-tag-loader').style.display = 'none';
  document.getElementById('sync-progress').style.display = 'inherit';
  await reconcile_tags();
  await loop_tags();
  console.log('Process Completed...');
}


function setup_modal(){
  return new Promise((resolve,reject) => {
    document.getElementById('sync_error_list').innerHTML = '';
    document.getElementById('cur_num').innerHTML = '0';
    document.getElementById('tot_num').innerHTML = '0';
    document.getElementById('sync-progress-bar').style.width = '0%';
    resolve();
    //If error occurs...
    reject(new Error('error message'));
  });
}


function get_shopify_products(){
  return new Promise((resolve,reject) => {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           // Typical action to be performed when the document is ready:
           var r = JSON.parse(this.responseText);
          if(r.response === 'GOOD'){
            shopify_products = r.products;
            resolve();
          }else{
            toast_alert('ERROR',r.message,'top-right','error',false);
            reject(new Error("Error: "+r.message));
          }
        }
    };
    xhttp.open("GET", "assets/shopify/get-all-products.php", true);
    xhttp.send();
  });
}


function get_untagged_products(){
  return new Promise((resolve,reject) => {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           // Typical action to be performed when the document is ready:
           var r = JSON.parse(this.responseText);
          if(r.response === 'GOOD'){
            untagged_products = r.products;
            resolve();
          }else{
            toast_alert('ERROR',r.message,'top-right','error',false);
            reject(new Error("Error: "+r.message));
          }
        }
    };
    xhttp.open("GET", "global/php/get-untagged-products.php", true);
    xhttp.send();
  });
}


function reconcile_tags(){
  return new Promise((resolve,reject) => {
    untagged_products.forEach(function(item, index){
      //console.log(item.upc_code);
      var result = '';
      result = $.grep(shopify_products, function(e){ return e.variants[0].barcode === item.upc_code; });
      if(result.length > 0) {
        console.log(result);
        to_be_tagged.push(result);
      }else{
        var rdata = JSON.parse(item.request_data);
        add_sync_error(item.upc_code+' -> '+rdata.product_title);
      }
    });
    document.getElementById('tot_num').innerHTML = to_be_tagged.length;
    resolve();
  });
}


function loop_tags(){
  return new Promise((resolve,reject) => {
    //Do Something
    var i = 0;
    to_be_tagged.forEach(async function(item, index){
      await add_tags(item);
      i++;
      var percent = (i / to_be_tagged.length) * 100;
      document.getElementById('cur_num').innerHTML = i;
      document.getElementById('sync-progress-bar').style.width = percent+'%';
      if(i >= to_be_tagged.length){
        resolve();
      }
    });
  });
}


function add_tags(d){
  return new Promise((resolve,reject) => {
    console.log(d[0].variants);
    var url = 'assets/shopify/update-product-tags.php';
    var params = 'upc_code='+d[0].variants[0].barcode+'&product_id='+d[0].id;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {//Call a function when the state changes.
        if(xhr.readyState == 4 && xhr.status == 200) {
          //Do Something...
          var r = JSON.parse(this.responseText);
          if(r.response === 'GOOD'){
            console.log(r);
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