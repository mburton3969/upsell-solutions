var catLevel = 0;
function get_cats(lvl,pid,setCat){
  //console.warn(setCat);
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
          if(r[i].id === '11450' || r[i].id === setCat){
            o.setAttribute('selected','selected');
          }
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
      
      if(lvl === 1){
        get_cats(2,11450);
      }

    }
  }
  xmlhttp.open("GET","assets/php/get-categories.php?level="+lvl+"&pid="+pid,true);
  xmlhttp.send();
}


function get_store_cats(lvl,cid,setStoreCat){
  console.log(lvl+' -> '+cid);
  var scb = document.getElementById('store_cat_box');
  
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      if(this.responseText.includes("Auth token is hard expired")){
        window.location = 'assets/php/refresh-token-test.php';
        return;
      }
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
      var r_cat = res.CustomCategory;
      console.log(r_cat);
      
      if(lvl === 1){
        scb.innerHTML = '';
          var s = document.createElement('select');
          s.id = 'product_store_category_'+lvl;
          s.setAttribute('name','product_store_category_'+lvl);
          s.setAttribute('class','form-control');
          s.setAttribute('onchange','get_store_cats('+(lvl + 1)+',this.value);');
          var o = document.createElement('option');
          o.value = '';
          if(lvl === 1){
            o.text = 'Select Store Category';
          }else{
            o.text = 'Select Store Sub-Category';
          }
          s.appendChild(o);
           for(var i = 0; i < r_cat.length; i++){
            r_cat.sort();
            var r = r_cat[i];
            var o = document.createElement('option');
            o.value = r.CategoryID;
            o.text = r.Name;
            if(r.CategoryID === setStoreCat){
              o.setAttribute('selected','selected');
            }
            s.appendChild(o);
            console.warn('Store Category: '+r.Name+' -> '+r.CategoryID);
          }
          scb.appendChild(s);
        }
      
      
      if(lvl === 2){
        if(document.getElementById('product_store_category_'+lvl)){
          document.getElementById('product_store_category_'+lvl).remove();
        }
            for(var i = 0; i < r_cat.length; i++){
              var r = r_cat[i];
              console.log(r.ChildCategory);
              if(Number(r.CategoryID) === Number(cid)){
                if(r.ChildCategory){
                  var s = document.createElement('select');
                  s.id = 'product_store_category_'+lvl;
                  s.setAttribute('name','product_store_category_'+lvl);
                  s.setAttribute('class','form-control');
                  s.setAttribute('onchange','get_store_cats('+(lvl + 1)+',this.value);');
                  var o = document.createElement('option');
                  o.value = '';
                  if(lvl === 1){
                    o.text = 'Select Store Category';
                  }else{
                    o.text = 'Select Store Sub-Category';
                  }
                  s.appendChild(o);
                }
                for(var ii = 0; ii < r.ChildCategory.length; ii++){
                  r.ChildCategory.sort();
                  var cc = r.ChildCategory[ii];
                  var o = document.createElement('option');
                  o.value = cc.CategoryID;
                  o.text = cc.Name;
                  s.appendChild(o);
                  console.warn("Store Child Category: "+cc.Name);
                }
              }
            }
          scb.appendChild(s);
      }
      
      //Set Current Store Category...
      if(lvl > 1){
      	var csc = document.getElementById('cur_store_cat');
        csc.value = Number(cid);
      }
      
      //If 1st Category is auto-set, get 2nd categories...
      if(lvl === 1 && setStoreCat === 25334048017){
        get_store_cats(2,setStoreCat);
      }

    }
  }
  xmlhttp.open("GET","assets/php/get-store.php",true);
  xmlhttp.send();
}


function sortSelect(selElem) {
    var tmpAry = new Array();
    for (var i=0;i<selElem.options.length;i++) {
        tmpAry[i] = new Array();
        tmpAry[i][0] = selElem.options[i].text;
        tmpAry[i][1] = selElem.options[i].value;
    }
    tmpAry.sort();
    while (selElem.options.length > 0) {
        selElem.options[0] = null;
    }
    for (var i=0;i<tmpAry.length;i++) {
        var op = new Option(tmpAry[i][0], tmpAry[i][1]);
        selElem.options[i] = op;
    }
    return;
}