//Global Variables...
var loaded = 0;
var updated = 0;
var ld = document.getElementById('sb_loaded');
var ud = document.getElementById('sb_updated');
var nf_items = [];

function sleep(milliseconds) {
  console.log('Sleep...');
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}


async function init_retrofit(){
  var items = await get_all_items();
  console.log('SellBrite Items Loaded...');
  console.log('Items Loaded: '+items.length);
  for(var iii = 0; iii <= items.length; iii++){
    var bin = await update_item(items[iii]);
    if(bin === 'Not Found'){
      console.warn(bin);
      nf_items.push(items[iii]);
    }else{
      console.log('Item Created Successfully');
      var inv = await update_inv(items[iii],bin);
      console.log(inv);
      var del = await delete_item(items[iii]);
      console.log(del);
    }
    //sleep(250);
  }
  /*items.forEach(async function(itm){
    var bin = await update_item(itm);
    if(bin === 'Not Found'){
      console.warn(bin);
      nf_items.push(itm);
    }else{
      console.log('Item Created Successfully');
      var inv = await update_inv(itm,bin);
      console.log(inv);
      var del = await delete_item(itm);
      console.log(del);
    }
    sleep(250);
  });*/
}


async function get_all_items(){
    var itms = [];
    var trip = false;
    var i = 1;
    while(trip === false){
      console.log('i='+i);
      var prods = await get_items(i);
      console.log(prods.length);
      if(prods.length > 0){
        //itms.push(prods);
        prods.forEach(function(p){
          if(p.upc === 'Does not apply' || p.upc === 'Does Not Apply' || p.upc === 'Does Not apply' || p.upc === 'does not apply' || p.upc === 'does not Apply' || p.upc === 'does Not apply'){
            nf_items.push(p);
          }else{
            itms.push(p);
            loaded++;
          }
          ld.innerHTML = loaded;
        });
        console.log(itms);
        console.log(itms.length);
        i++;
        //trip = true;
      }else{
        trip = true;
      }
    }
  return new Promise((resolve,reject) => {
    //Do Something
    resolve(itms);
  });
}


function get_items(page){
  return new Promise((resolve,reject) => {
    
     var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //Typical action to be performed when the document is ready:
            var r = JSON.parse(this.responseText);
            if(r.response === 'GOOD'){
              resolve(r.products);
            }else{
              //If error occurs...
              reject(new Error('error message'));
            }

          }
      };
      xhttp.open("GET", "../get-all-products.php?page="+page+"&limit=100", true);
      xhttp.send();
  });
}


function update_item(item){
  return new Promise((resolve,reject) => {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Typical action to be performed when the document is ready:
          var r = JSON.parse(this.responseText);
          if(r.response === 'GOOD'){
            updated++;
            ud.innerHTML = updated;
            resolve(r.product_label);
          }else{
            //If error occurs...
            resolve('Not Found');
            //reject(new Error('error message'));
          }
        }
    };
    xhttp.open("GET", "update-item.php?upc_code="+item.upc, true);
    xhttp.send();
  });
}


function update_inv(item,bin){
  return new Promise((resolve,reject) => {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
          // Typical action to be performed when the document is ready:
          var r = JSON.parse(this.responseText);
          if(r.response === 'GOOD'){
            resolve(r.message);
          }else{
            //If error occurs...
            reject(new Error('error message'));
          }
        }
    };
    xhttp.open("GET", "../update-inventory.php?product_code="+item.upc+"&product_quantity="+item.quantity+"&product_label="+bin, true);
    xhttp.send();
  });
}


function delete_item(item){
  return new Promise((resolve,reject) => {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
          // Typical action to be performed when the document is ready:
          var r = JSON.parse(this.responseText);
          if(r.response === 'GOOD'){
            resolve(r.message);
          }else{
            //If error occurs...
            reject(new Error('error message'));
          }
        }
    };
    xhttp.open("GET", "delete-item.php?upc_code="+item.sku, true);
    if(item.sku !== item.upc){
      xhttp.send();
    }else{
      resolve('Item Delete Bypassed...');
    }
  });
}


function download_nf_items(){
  let csvContent = "data:text/csv;charset=utf-8,";
  var header = [];
  for(var key in nf_items[0]){
    header.push(key);
  }
  let headers = header.join(",");
  csvContent += headers + "\r\n";
  nf_items.forEach(function(rowArray) {
    var row = [];
    for(var key in rowArray){
      if(key === 'description'){
        row.push(escape(rowArray[key]));
      }else{
        row.push(rowArray[key]);
      }
    }
    let rows = row.join(",");
    csvContent += rows + "\r\n";
  });
  var encodedUri = encodeURI(csvContent);
  window.open(encodedUri);
}


/*------------------------------------------------Shopify Sync Functions---------------------------------------------*/

