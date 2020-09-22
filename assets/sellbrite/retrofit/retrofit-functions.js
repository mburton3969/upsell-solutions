//Global Variables...
var loaded = 0;
var updated = 0;
var ld = document.getElementById('sb_loaded');
var ud = document.getElementById('sb_updated');


async function init_retrofit(){
  var items = await get_all_items();
  console.log('SellBrite Items Loaded...');
  items.forEach(async function(itm){
    await update_item(itm);
  });
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
          itms.push(p);
          loaded++;
          ld.innerHTML = loaded;
        });
        console.log(itms);
        console.log(itms.length);
        i++;
        trip = true;
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
      xhttp.open("GET", "../get-all-products.php?page="+page, true);
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
            resolve();
          }else{
            //If error occurs...
            reject(new Error('error message'));
          }
        }
    };
    xhttp.open("GET", "update-item.php?upc_code="+item.upc, true);
    xhttp.send();
  });
}


/*------------------------------------------------Shopify Sync Functions---------------------------------------------*/

