//Global Variables...
var shopify_products;
var untagged_products;

async function init_data(){
  document.getElementById('sync-tag-loader').style.display = 'inline';
  $('#syncTagsModal').modal('toggle');
  await get_shopify_products();
  console.log('Shopify Products:');
  console.log(shopify_products);
  await get_untagged_products();
  console.log('Untagged Products:');
  console.log(untagged_products);
  document.getElementById('sync-tag-loader').style.display = 'none';
  document.getElementById('sync-progress').style.display = 'inherit';
  reconcile_tags();
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
            reject(new Error('Error: '+r.message));
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
            reject(new Error('Error: '+r.message));
          }
        }
    };
    xhttp.open("GET", "global/php/get-untagged-products.php", true);
    xhttp.send();
  });
}


async function reconcile_tags(){
  untagged_products.forEach(function(item, index){
    //console.log(item.upc_code);
    var result = $.grep(shopify_products, function(e){ return e.variants[0].barcode === item.upc_code; });
    if(result !== undefined || result.length != 0) {
      console.log(result);
    }
  });
  //var target = "production";
  //var result = $.grep(data, function(e){ return e.target == target; });
  //console.log(result);
}


function add_sync_error(err){
  var el = document.getElementById('sync_error_list');
  var i = document.createElement('li');
  i.innerHTML = err;
  el.appendChild(i);
}