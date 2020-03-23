//Global Variables...
var item_specifics = [];

function new_specific(spec, values) {
  if(spec === '' || spec === undefined){
    var sName = prompt("Name of Item Specific:");
    var dd = false;
  }else{
    var sName = spec;
    var dd = true;
  }
  //alert(sName);
    if(sName === '' || sName === null){
        alert('Please Enter an Item Specific Category');
        return;
    }else{
        sName = sName.replace(' ','_');
    }
    //Create Input to add...
  if(dd === false){
    var input = document.createElement('input');
    input.setAttribute('type','text');
    input.setAttribute('id','product_'+sName);
    input.setAttribute('style','width:32%;display:inline;');
    input.setAttribute('name','product_'+sName);
    input.setAttribute('class','form-control');
    input.setAttribute('placeholder',sName);
    input.setAttribute('required','required');
  }else{
    var select = document.createElement('select');
    select.setAttribute('id','product_'+sName);
    select.setAttribute('style','width:32%;display:inline;');
    select.setAttribute('name','product_'+sName);
    select.setAttribute('class','form-control');
    select.setAttribute('required','required');
    var option = document.createElement('option');
    option.setAttribute('value','');
    var t = document.createTextNode("Select "+sName);
    option.appendChild(t);
    select.appendChild(option);
    for(var ii = 0; ii < values.length; ii++){
      var option = document.createElement('option');
      option.setAttribute('value',values[ii]);
      var t = document.createTextNode(values[ii]);
      option.appendChild(t);
      select.appendChild(option);
    }
  }

    var div = document.getElementById('item_specifics');
  if(dd === false){
    div.appendChild(input);
  }else{
    div.appendChild(select);
  }
    item_specifics.push(sName);
    document.getElementById('item_specifics_array').value = item_specifics;
    console.log('Input added to the application');
}

function getItemSpecifics(cat_code){
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
        for(var i = 0; i < r.ItemSpecific.length; i++){
          var x = r.ItemSpecific[i];
          new_specific(x.Name, x.Values);
        }
      }
      
    }
  }
  xmlhttp.open("GET","assets/php/get-item-specifics.php?category_id="+cat_code,true);
  xmlhttp.send();
}