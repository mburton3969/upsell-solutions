var catLevel = 0;
function get_cats(lvl,pid){
  //Clear Item Specifics Inputs...
  document.getElementById('item_specifics').innerHTML = '';
  
  var cb = document.getElementById('cat_box');
  
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      if(this.responseText === '' || this.responseText === 'null'){
        var cc = document.getElementById('product_category_'+(lvl - 1));
        var ccf = document.getElementById('cur_cat');
        ccf.value = cc.value;
        console.log('Category set to: '+cc.value);
        console.log('No Results Found');
        getItemSpecifics(cc.value);
        return;
      }
      var res = JSON.parse(this.responseText);
      var r = res.cat;
      console.log(r);
      
      if(lvl === 1){
        cb.innerHTML = '';
      }
      
      var ecb = document.getElementById('product_category_'+lvl);
      if(ecb){
        var cntr = lvl;
        while(cntr <= 6){
          var cecb = document.getElementById('product_category_'+cntr);
          if(cecb){
            cecb.remove();
          }
          cntr++;
        }
      }
      
        catLevel = lvl;
        var nLVL = lvl + 1;
        var s = document.createElement('select');
        s.id = 'product_category_'+lvl;
        s.setAttribute('name','product_category_'+lvl);
        s.setAttribute('class','form-control');
        s.setAttribute('onchange','get_cats('+nLVL+',this.value);');
        var o = document.createElement('option');
        o.value = '';
        if(lvl === 1){
          o.text = 'Select Category';
        }else{
          o.text = 'Select Sub-Category';
        }
        s.appendChild(o);
        for(var i = 0; i < r.length; i++){
          var o = document.createElement('option');
          o.value = r[i].id;
          o.text = r[i].name;
          s.appendChild(o);
        }
        cb.appendChild(s);
      
      //Set Current Category...
      if((lvl - 1) !== 0){
        var cc = document.getElementById('product_category_'+(lvl - 1));
        var ccf = document.getElementById('cur_cat');
        ccf.value = cc.value;
        console.log('Category set to: '+cc.value);
      }

    }
  }
  xmlhttp.open("GET","assets/php/get-categories.php?level="+lvl+"&pid="+pid,true);
  xmlhttp.send();
}